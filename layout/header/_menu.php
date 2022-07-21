<?php
	$page = isset($_GET['page']) ? $_GET['page'] : "index";

	global $link;
    if (session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    if (!isset($_SESSION['username']))
    {
        header("Location: ../../auth/login.php ");
        exit();
    }

    $username = $_SESSION['username'];
    ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));
    $row = mysqli_fetch_array($result);

    $banned = $row['banned'];
    $lastreset = $row['lastreset'];
    if (!is_null($banned) || $_SESSION['logindate'] < $lastreset || mysqli_num_rows($result) === 0)
    {
        echo "<meta http-equiv='Refresh' Content='0; url=../../../login/'>";
        session_destroy();
        exit();
    }
	
	$role = $row['role'];
    $_SESSION['role'] = $role;

    $expires = $row['expires'];
    if (in_array($role, array(
        "developer",
        "seller"
    )))
    {
        $_SESSION['timeleft'] = expireCheck($username, $expires);
    }

function expireCheck($username, $expires)
{
    global $link;
    if ($expires < time())
    {
        $_SESSION['role'] = "tester";
        mysqli_query($link, "UPDATE `accounts` SET `role` = 'tester' WHERE `username` = '$username'");
        unset($_SESSION["timeleft"]);
    }
    if ($expires - time() < 2629743) // account expires in month
    
    {
        return true;
    }
    else
    {
        return false;
    }
}
?>						
									<!--begin::Menu wrapper-->
									<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
										<!--begin::Menu-->
										<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
											<div class="menu-item me-lg-1">
												<a class="menu-link <?php if($page == 'docs') { echo 'active'; } ?> py-3" href="?page=docs">
													<span class="menu-title">Documentation</span>
												</a>
											</div>
											<?php if ($_SESSION['timeleft'])
											{ ?>
											<a class="menu-link py-3" href="?page=account">
												<span class="badge badge-warning">Your account subscription expires, in less than a month, check account details for exact date.</span>
											</a>
												<?php
											} ?>
											
								
									
										</div>
										<!--end::Menu-->
									</div>
									<!--end::Menu wrapper-->
									