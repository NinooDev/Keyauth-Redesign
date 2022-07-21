<?php
require '../../app/includes/connection.php';
require '../../app/includes/misc/autoload.phtml';
require '../include.php';

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (!isset($_SESSION['panelapp']))
{
    die("You must go to your panel login first then visit this page");
}
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Upgrade</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://cdn.keyauth.uk/assets/img/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<link href="../../app/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="../../app/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<meta name="robots" content="nosnippet, nofollow, noindex"/>
</head>
<body id="kt_body" class="bg-dark">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<a href="<?php echo $_SESSION["url"]; ?>" class="mb-12">
						<img alt="Logo" src="../../app/assets/media/logos/favicon.ico" class="h-40px" />
					</a>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form method="post">
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-light mb-3"><?php echo 'Upgrade Account'; ?></h1>
								<!--end::Title-->
								<!--begin::Link-->
								
								<!--end::Link-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-light">Username</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="username" autocomplete="on" />
								<div class="form-group row">
                                </br>
								<!--end::Input-->
							</div>
							<!--end::Input group-->
					
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-light">License</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="license" autocomplete="on" />
								<div class="form-group row">
                                </br>
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button name="upgrade" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Continue</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<!--end::Submit button-->
								
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
	</div>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <?php
if (isset($_POST['upgrade']))
{
    $username = misc\etc\sanitize($_POST['username']);
    $license = misc\etc\sanitize($_POST['license']);

    // search username
    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$username' AND `app` = '".$_SESSION['panelapp']."'");

    // check if username already exists
    if (mysqli_num_rows($result) == 0)
    {
        error("Username doesn\'t exist!");
        return;
    }

    // search for key
    $result = mysqli_query($link, "SELECT * FROM `keys` WHERE `key` = '$license' AND `app` = '".$_SESSION['panelapp']."'");

    // check if key exists
    if (mysqli_num_rows($result) == 0)
    {
		error("License doesn\'t exist!");
        return;
    }

    // get key info
    while ($row = mysqli_fetch_array($result))
    {

        $expires = $row['expires'];

        $status = $row['status'];

        $level = $row['level'];

    }

    // check if used
    if ($status == "Used")
    {
		error("License already used!");
        return;
    }

    // set key to used
    mysqli_query($link, "UPDATE `keys` SET `status` = 'Used' WHERE `key` = '$license'");

    // add current time to key time
    $expiry = $expires + time();

    $result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `app` = '".$_SESSION['panelapp']."' AND `level` = '$level'");

    $num = mysqli_num_rows($result);

    if ($num == 0)
    {
		error("License level doesn\'t correspond to a subscription level!");
        return;
    }

    $subname = mysqli_fetch_array($result) ['name'];

    mysqli_query($link, "INSERT INTO `subs` (`user`, `subscription`, `expiry`, `app`) VALUES ('$username','$subname', '$expiry', '".$_SESSION['panelapp']."')");
	success("Successfully Upgraded!");
}
?>
</body>
</html>