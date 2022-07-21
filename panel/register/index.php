<?php
require '../../app/includes/connection.php';
require '../../app/includes/misc/autoload.phtml';
require '../../app/includes/api/1.0/autoload.phtml';
require '../../app/includes/api/shared/autoload.phtml';
require '../include.php';
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
	
if(!isset($_SESSION['panelapp']))
{
	die("You must go to your panel login first then visit this page");
}
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register</title>
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
								<h1 class="text-light mb-3"><?php echo 'Register To ' . $_SESSION['panelname'] . ' Panel'; ?></h1>
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
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-light fs-6 mb-0">Password</label>
									<!--end::Label-->
									<!--begin::Link-->
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="on" />
								<!--end::Input-->
							</div>
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
								<button name="register" class="btn btn-lg btn-primary w-100 mb-5">
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
	
	
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <?php
if (isset($_POST['register']))
{
    if (empty($_POST['username']) || empty($_POST['password']))
    {

        error("You must fill in all the fields!");
        return;
    }
    
	$username = misc\etc\sanitize($_POST['username']);
	$password = misc\etc\sanitize($_POST['password']);
	$license = misc\etc\sanitize($_POST['license']);
    
	$resp = api\v1_0\register($username, $license, $password, NULL, $_SESSION['panelapp']);
	switch($resp)
	{
		case 'username_taken':
			error("Username taken!");
			break;
		case 'key_not_found':
			error("License doesn\'t exist!");
			break;
		case 'key_already_used':
			error("License already used!");
			break;
		case 'key_banned':
			error("License is banned!");
			break;
		default:
			$_SESSION['un'] = $username;
			header("location: ../dashboard/");
			break;
	}
}
?>
</body>
</html>