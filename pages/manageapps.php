<?php
include '../includes/connection.php';
include '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']))
{
    header("Location: ../auth/login.php");
    exit();
}

    $username = $_SESSION['username'];
    ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));
    $row = mysqli_fetch_array($result);

    $banned = $row['banned'];
    $lastreset = $row['lastreset'];
    if (!is_null($banned) || $_SESSION['logindate'] < $lastreset || mysqli_num_rows($result) === 0)
    {
        echo "<meta http-equiv='Refresh' Content='0; url=../auth/login.php'>";
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
        $_SESSION['timeleft'] = expire_check($username, $expires);
    }

    if ($role == "Reseller")
    {
        die('Resellers Not Allowed Here');
    }
    if ($role == "Manager")
    {
        die('Managers Not Allowed Here');
    }

    $list[] = $row['format'];
    $list[] = $row['amount'];
    $list[] = $row['lvl'];
    $list[] = $row['note'];
    $list[] = $row['duration'];
	
	$_SESSION['licensePresave'] = $list;

?>

<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">

    <?php
            $appsecret = $_SESSION["app"];
            ($result = mysqli_query($link, "SELECT * FROM `apps` WHERE `secret` = '$appsecret'")) or die(mysqli_error($link));

            $row = mysqli_fetch_array($result);
            $appname = $row["name"];
            $secret = $row["secret"];
            $version = $row["ver"];

            ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));

            $row = mysqli_fetch_array($result);
            $ownerid = $row["ownerid"];
            

    ?>
    <div class="card">
    <div class="card-body">
    <div class="table-responsive">
    <h2>Application: <?php echo $appname;?></h2>
    <h3>Owner ID: <?php echo $ownerid;?></h3>
    <h3>Secret: <?php echo $secret;?></h3>
    <h3>Version: <?php echo $version;?></h3>
    </div>
    </div>
    </div>
    <br>

    <a class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#create_app">Create App</a>
    <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#rename_app">Rename App</a>
    <?php
        ($result = mysqli_query($link, "SELECT * FROM `apps` WHERE `secret` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
        $row = mysqli_fetch_array($result);
        if (!$row['paused'])
        {
			?>
            <a class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#pause_app">Pause App & Users</a>
			<?php
		}
        else
        {
            ?>
            <a class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#unpause_app">Unpause App & Users</a>
			<?php
        }
        ?>
    <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#refresh_app">Refresh App Secret</a>
    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_app">Delete App</a>    

    <br></br>
    <div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="file_export" class="table table-striped table-bordered display">
<th>Application</th>
<th>Action</th>
<?php

$username = $_SESSION['username'];
$rows = array();
($result = mysqli_query($link, "SELECT * FROM `apps` WHERE `owner` = '$username'"));
while ($r = mysqli_fetch_assoc($result))
{
    $rows[] = $r;
}

foreach ($rows as $row)
{
    $names = $row['name'];
    $appsecret = $_SESSION["app"];
    
    ($result = mysqli_query($link, "SELECT * FROM `apps` WHERE `owner` = '$username' AND `secret` = '$appsecret'"));
    $row = mysqli_fetch_array($result);


    ($result2 = mysqli_query($link, "SELECT * FROM `apps` WHERE `owner` = '$username' AND `name` = '$names'"));
    $row2 = mysqli_fetch_array($result2);
    $pausebadge = '<span class="badge badge-warning">Paused</span>';
    if($row2["paused"])
    {
        
                if (mysqli_num_rows($result) == 1)
            {
                
                if($_SESSION["selectedapp"] == $names)
                {
                    echo'
                                <tr>
                
                                <td>' . $names . ' <span class="badge badge-warning">Paused</span> </td> 
                                <form method="POST"><td><button type="buton" value="'. $names .'" name="selectapp" class="btn btn-success aria-expanded="false"> Selected </button>
                                                        
                    
                '; 
                }else
                {
                    echo'
                
                            <tr>
            
                            <td>' . $names . ' <span class="badge badge-warning">Paused</span> </td>
                            <form method="POST"><td><button type="buton" value="'. $names .'" name="selectapp" class="btn btn-secondary aria-expanded="false"> Select </button>
                        '; 
                }
            
            }else
            {
                    echo'
            
                            <tr>
            
                            <td>' . $names . ' <span class="badge badge-warning">Paused</span> </td>
                            <form method="POST"><td><button type="buton" value="'. $names .'" name="selectapp" class="btn btn-secondary aria-expanded="false"> Select </button>                                       
                        '; 
            }

    }else
    {

        if (mysqli_num_rows($result) == 1)
            {
                
                if($_SESSION["selectedapp"] == $names)
                {
                    echo'
                                <tr>
                
                                <td>' . $names . '</td> 
                                <form method="POST"><td><button type="buton" value="'. $names .'" name="selectapp" class="btn btn-success aria-expanded="false"> Selected </button>
                                                        
                    
                '; 
                }else
                {
                    echo'
                
                            <tr>
            
                            <td>' . $names . '</td>
                            <form method="POST"><td><button type="buton" value="'. $names .'" name="selectapp" class="btn btn-secondary aria-expanded="false"> Select </button>
                        '; 
                }
            
            }else
            {
                    echo'
            
                            <tr>
            
                            <td>' . $names . '</td>
                            <form method="POST"><td><button type="buton" value="'. $names .'" name="selectapp" class="btn btn-secondary aria-expanded="false"> Select </button>                                       
                        '; 
            }

    }

    if (isset($_POST['selectapp']))
    {
        $_SESSION["selectedapp"] = $_POST['selectapp'];
        $selectedname = $_POST['selectapp'];
        ($result = mysqli_query($link, "SELECT * FROM `apps` WHERE `owner` = '$username' AND `name` = '$selectedname'"));
        $row = mysqli_fetch_array($result);
        mysqli_query($link, "UPDATE `accounts` SET `selectedapp` = '" . $selectedname . "'WHERE `username` = '" . $_SESSION['username'] . "'");        
        $_SESSION["app"] = $row["secret"];
        echo "<meta http-equiv='Refresh' Content='0'>";
    }

    

}	        


?>

<tr>
<th>Application</th>
<th>Action</th>
                                    </table>
                                </div>
                            </div>
                        </div>									



	<!--begin::Modal - Create App-->
    <div class="modal fade" id="create_app" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Create App</h2>

                <!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
						</div>
				<!--end::Close-->
            </div>
						<form method="post">
          					  <div class="modal-body">
									<div class="current" data-kt-stepper-element="content">
										<div class="w-100">
											<!--begin::Input group-->
											<div class="fv-row mb-10">
												<!--begin::Label-->
												<label class="d-flex align-items-center fs-5 fw-bold mb-2">
													<span class="required">App Name</span>
													<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify your unique app name"></i>
												</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" placeholder="Application Name" class="form-control form-control-lg form-control-solid" name="appname" />
												<!--end::Input-->
											</div>
											<!--end::Input group-->	
										</div>
									</div>
										<div class="modal-footer">
											<button name="create_app" class="btn btn-primary">Submit</button>
										</div>
            					</div>
						</form>
					<!--end::Modal header-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - Create App-->


		<!--begin::Modal - Rename App-->
		<div class="modal fade" id="rename_app" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Rename App</h2>

                <!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
						</div>
				<!--end::Close-->
            </div>
						<form method="post">
          					  <div class="modal-body">
									<div class="current" data-kt-stepper-element="content">
										<div class="w-100">
											<!--begin::Input group-->
											<div class="fv-row mb-10">
												<!--begin::Label-->
												<label class="d-flex align-items-center fs-5 fw-bold mb-2">
													<span class="required">App Name</span>
													<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify your unique app name"></i>
												</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" placeholder="New Application Name" class="form-control form-control-lg form-control-solid" name="appname" />
												<!--end::Input-->
											</div>
											<!--end::Input group-->	
										</div>
									</div>
										<div class="modal-footer">
											<button name="rename_app" class="btn btn-primary">Submit</button>
										</div>
            					</div>
						</form>
					<!--end::Modal header-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - Rename App-->


<!--begin::Modal - Pause App-->
<div class="modal fade" tabindex="-1" id="pause_app">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Pause Application</h2>

                <!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
						</div>
				<!--end::Close-->
            </div>
            <div class="modal-body">
                <label class="fs-5 fw-bold mb-2">
                <p> Are you sure you want to pause app & all users? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button name="pauseapp" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Pause App-->
		

<!--begin::Modal - Unpause App-->
<div class="modal fade" tabindex="-1" id="unpause_app">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Pause Application</h2>

                <!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
						</div>
				<!--end::Close-->
            </div>
            <div class="modal-body">
                <label class="fs-5 fw-bold mb-2">
                <p> Are you sure you want to unpause app & all users? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="unpauseapp" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Unpause App-->

<!--begin::Modal - Refresh App-->
<div class="modal fade" tabindex="-1" id="refresh_app">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Refresh Application</h2>

                <!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
						</div>
				<!--end::Close-->
            </div>
            <div class="modal-body">
                <label class="fs-5 fw-bold mb-2">
                <p> Are you sure you want to reset application secret? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="refreshapp" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Refresh App-->

<!--begin::Modal - Delete App-->
<div class="modal fade" tabindex="-1" id="delete_app">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete Application</h2>

                <!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
									<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
								</svg>
							</span>
						</div>
				<!--end::Close-->
            </div>
            <div class="modal-body">
                <label class="fs-5 fw-bold mb-2">
                <p> Are you sure you want to delete application? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="deleteapp" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Delete App-->


<?php

if (isset($_POST['create_app']))
{

    $appname = sanitize($_POST['appname']);
	if($appname == "")
	{
		error("Input a valid name");
		return;
	}

            $result = mysqli_query($link, "SELECT * FROM apps WHERE name='$appname' AND owner='" . $_SESSION['username'] . "'");
            if (mysqli_num_rows($result) > 0)
            {
                mysqli_close($link);
                error("You already own application with this name!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
                return;
            }

            $owner = $_SESSION['username'];

            if ($role == "tester")
            {
                $result = mysqli_query($link, "SELECT * FROM apps WHERE owner='$owner'");

                if (mysqli_num_rows($result) > 0)
                {
                    mysqli_close($link);
                    error("Tester plan only supports one application!");
                    echo "<meta http-equiv='Refresh' Content='2;'>";

                    return;
                }

            }

            if ($role == "Manager")
            {
                mysqli_close($link);
                error("Manager Accounts Are Not Allowed To Create Applications");
                echo "<meta http-equiv='Refresh' Content='2;'>";
                return;
            }

            $ownerid = $_SESSION['ownerid'];
            $clientsecret = hash('sha256', generateRandomString());
            $algos = array(
                'ripemd128',
                'md5',
                'md4',
                'tiger128,4',
                'haval128,3',
                'haval128,4',
                'haval128,5'
            );
            $sellerkey = hash($algos[array_rand($algos) ], generateRandomString());
			mysqli_query($link, "INSERT INTO `subscriptions` (`name`, `level`, `app`) VALUES ('default', '1', '$clientsecret')");
            mysqli_query($link, "INSERT INTO `apps`(`owner`, `name`, `secret`, `ownerid`, `enabled`, `hwidcheck`, `sellerkey`) VALUES ('" . $owner . "','" . $appname . "','" . $clientsecret . "','$ownerid', '1','1','$sellerkey')");
			if (mysqli_affected_rows($link) != 0)
            {
                $_SESSION['secret'] = $clientsecret;
                success("Successfully Created App!");
                $_SESSION['app'] = $clientsecret;
                $_SESSION["selectedapp"] = $appname;
                mysqli_query($link, "UPDATE `accounts` SET `selectedapp` = '" . $appname . "'WHERE `username` = '" . $_SESSION['username'] . "'");        
                $_SESSION['name'] = $appname;
                $_SESSION['sellerkey'] = $sellerkey;
                echo "<meta http-equiv='Refresh' Content='2;'>";
            }
            else
            {
                error("Failed to create application!");
            }
}

if (isset($_POST['rename_app']))
{
    $appname = sanitize($_POST['appname']);
	if($appname == "")
	{
		error("Input a valid name");
		return;
	}
    if ($role == "Manager")
            {
                error("Manager Accounts Aren\'t Allowed To Rename Applications");
                echo "<meta http-equiv='Refresh' Content='2;'>";
                return;
            }
            $result = mysqli_query($link, "SELECT * FROM `apps` WHERE `owner` = '" . $_SESSION['username'] . "' AND `name` = '$appname'");
            $num = mysqli_num_rows($result);
            if ($num > 0)
            {
                error("You already have an application with this name!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
                return;
            }
            mysqli_query($link, "UPDATE `apps` SET `name` = '$appname' WHERE `secret` = '" . $_SESSION['app'] . "' AND `owner` = '" . $_SESSION['username'] . "'");
            $_SESSION['name'] = $appname;
            if (mysqli_affected_rows($link) != 0)
            {
                success("Successfully Renamed App!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
                $_SESSION["selectedapp"] = $appname;
                mysqli_query($link, "UPDATE `accounts` SET `selectedapp` = '" . $appname . "'WHERE `username` = '" . $_SESSION['username'] . "'");        
            }
            else
            {
                error("Application Renamed Failed!");
                echo "<meta http-equiv='Refresh' Content='2;'>";
            }
}

if (isset($_POST['pauseapp']))
{
    if ($role == "Manager")
    {
        error("Manager accounts aren\'t allowed To pause applications");
        echo "<meta http-equiv='Refresh' Content='2;'>";
        return;
    }
    $result = mysqli_query($link, "SELECT * FROM `subs` WHERE `app` = '" . $_SESSION['app'] . "' AND `expiry` > '" . time() . "'");
    while ($row = mysqli_fetch_array($result))
    {
        $expires = $row['expiry'];
        $exp = $expires - time();
        mysqli_query($link, "UPDATE `subs` SET `paused` = 1, `expiry` = '$exp' WHERE `app` = '" . $_SESSION['app'] . "' AND `id` = '" . $row['id'] . "'");
    }
    mysqli_query($link, "UPDATE `apps` SET `paused` = 1 WHERE `secret` = '" . $_SESSION['app'] . "'");
    success("Paused application and any active subscriptions!");
    echo "<meta http-equiv='Refresh' Content='2'>";
}
if (isset($_POST['unpauseapp']))
{
    if ($role == "Manager")
    {
        error("Manager accounts aren\'t allowed To unpause applications");
        echo "<meta http-equiv='Refresh' Content='2;'>";
        return;
    }
    $result = mysqli_query($link, "SELECT * FROM `subs` WHERE `app` = '" . $_SESSION['app'] . "' AND `paused` = 1");
    while ($row = mysqli_fetch_array($result))
    {
        $expires = $row['expiry'];
        $exp = $expires + time();
        mysqli_query($link, "UPDATE `subs` SET `paused` = 0, `expiry` = '$exp' WHERE `app` = '" . $_SESSION['app'] . "' AND `id` = '" . $row['id'] . "'");
    }
    mysqli_query($link, "UPDATE `apps` SET `paused` = 0 WHERE `secret` = '" . $_SESSION['app'] . "'");
    success("Unpaused application and any paused subscriptions!");
    echo "<meta http-equiv='Refresh' Content='2'>";
}

if (isset($_POST['refreshapp']))
{
    $gen = generateRandomString();
    $new_secret = hash('sha256', $gen);
    if ($role == "Manager")
    {
        error("Manager Accounts Aren\'t Allowed To Refresh Applications");
        echo "<meta http-equiv='Refresh' Content='2;'>";
        return;
    }
    mysqli_query($link, "UPDATE `bans` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `files` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `keys` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `logs` SET `logapp` = '$new_secret' WHERE `logapp` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `subs` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `subscriptions` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `users` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `vars` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `webhooks` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `chatmsgs` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `chats` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `sessions` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `uservars` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `chatmutes` SET `app` = '$new_secret' WHERE `app` = '" . $_SESSION['app'] . "'");
    mysqli_query($link, "UPDATE `apps` SET `secret` = '$new_secret' WHERE `secret` = '" . $_SESSION['app'] . "' AND `owner` = '" . $_SESSION['username'] . "'");
    $_SESSION['app'] = $new_secret;
    $_SESSION['secret'] = $new_secret;
    if (mysqli_affected_rows($link) != 0)
    {
        success("Successfully Refreshed App!");
        echo "<meta http-equiv='Refresh' Content='2;'>";
    }
    else
    {
        error("Application Refresh Failed!");
        echo "<meta http-equiv='Refresh' Content='2;'>";
    }
}


if (isset($_POST['deleteapp']))
{
    if ($role == "Manager")
    {
        error("Manager Accounts Aren\'t Allowed To Delete Applications");
        echo "<meta http-equiv='Refresh' Content='2;'>";
        return;
    }
    $app = $_SESSION['app'];
    $owner = $_SESSION['username'];
    mysqli_query($link, "DELETE FROM `files` WHERE `app` = '$app'") or die(mysqli_error($link)); // delete files
    mysqli_query($link, "DELETE FROM `keys` WHERE `app` = '$app'") or die(mysqli_error($link)); // delete keys
    mysqli_query($link, "DELETE FROM `logs` WHERE `logapp` = '$app'") or die(mysqli_error($link)); // delete logs
    mysqli_query($link, "DELETE FROM `apps` WHERE `secret` = '$app'") or die(mysqli_error($link));
    if (mysqli_affected_rows($link) != 0)
    {
        $_SESSION['app'] = NULL;
        success("Successfully deleted App!");
        echo "<meta http-equiv='Refresh' Content='2;'>";
    }
    else
    {
        error("Application Deletion Failed!");
        echo "<meta http-equiv='Refresh' Content='2;'>";
    }
}

?>

</div>
<!--end::Container-->