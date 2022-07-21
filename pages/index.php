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
$_SESSION['role'] = $role;

    if ($role == "Reseller")
    {
        die('Resellers Not Allowed Here');
		
    }
?>							

<form method="POST">
<button name="dev" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Set to dev</button> 
<button name="seller" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Set to seller</button>
<button name="expiremax" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Set to expire to future</button>
<button name="expirenow" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Set to expire to now</button>
</form>
<?php
if (isset($_POST['dev']))
{
	$username = $_SESSION["username"];
	mysqli_query($link, "UPDATE `accounts` SET `role` = 'developer' WHERE `username` = '$username'");
	echo "<meta http-equiv='Refresh' Content='0;'>";
}
if (isset($_POST['seller']))
{
	$username = $_SESSION["username"];
	mysqli_query($link, "UPDATE `accounts` SET `role` = 'seller' WHERE `username` = '$username'");
	echo "<meta http-equiv='Refresh' Content='0;'>";
}
if (isset($_POST['expiremax']))
{
	$username = $_SESSION["username"];
	mysqli_query($link, "UPDATE `accounts` SET `expires` = '1801383639' WHERE `username` = '$username'");
	echo "<meta http-equiv='Refresh' Content='0;'>";
}
if (isset($_POST['expirenow']))
{
	$username = $_SESSION["username"];
	$now = time() + 20;
	mysqli_query($link, "UPDATE `accounts` SET `expires` = '$now' WHERE `username` = '$username'");
	echo "<meta http-equiv='Refresh' Content='0;'>";
}

?>
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
								
							<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
										<!--begin::Card widget 4-->
										<div class="card card-flush h-md-50 mb-5 mb-xl-10">
											<!--begin::Header-->
											<div class="card-header pt-5">
												<!--begin::Title-->
												<div class="card-title d-flex flex-column">
													<!--begin::Info-->
													<div class="d-flex align-items-center">
														<!--begin::Amount-->
														<span class="fs-2hx fw-bolder text-dark me-2 lh-1">USERS COUNT</span>
														<!--end::Amount-->
													</div>
													<!--end::Info-->
													<!--begin::Subtitle-->
													<span class="text-gray-400 pt-1 fw-bold fs-6">Total Users</span>
													<!--end::Subtitle-->
												</div>
												<!--end::Title-->
											</div>
											<!--end::Header-->
										</div>
										<!--end::Card widget 4-->
										<!--begin::Card widget 5-->
										<div class="card card-flush h-md-50 mb-xl-10">
											<!--begin::Header-->
											<div class="card-header pt-5">
												<!--begin::Title-->
												<div class="card-title d-flex flex-column">
													<!--begin::Info-->
													<div class="d-flex align-items-center">
														<!--begin::Amount-->
														<span class="fs-2hx fw-bolder text-dark me-2 lh-1">LICENSE COUNT</span>
														<!--end::Amount-->
													</div>
													<!--end::Info-->
													<!--begin::Subtitle-->
													<span class="text-gray-400 pt-1 fw-bold fs-6">Total Licenses</span>
													<!--end::Subtitle-->
												</div>
												<!--end::Title-->
											</div>
											<!--end::Header-->
										</div>
										<!--end::Card widget 5-->
						</div>
								
							</div>
							<!--end::Container-->

							