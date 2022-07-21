<?php
require '../app/includes/connection.php';
require '../app/includes/misc/autoload.phtml';
require './include.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['un']))
{
    header("Location: ../dashboard/");
    exit();
}

function htmlEncode($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$requrl = $_SERVER['REQUEST_URI'];

$uri = trim($_SERVER['REQUEST_URI'], '/');
$pieces = explode('/', $uri);
$owner = urldecode(misc\etc\sanitize($pieces[1]));
$username = urldecode(misc\etc\sanitize($pieces[2]));

$_SESSION["url"] = $requrl;

if (!strip_tags(htmlEncode($requrl)) || substr_count($requrl, '/') != 3)
{
    Die("Invalid Link, link should look something like https://keyauth.com/panel/mak/CSGI, where mak is the owner of the app, and CSGI is the app name.");
}

$result = mysqli_query($link, "SELECT * FROM `apps` WHERE `name` = '$username' AND `owner` = '$owner'");

if (mysqli_num_rows($result) == 0)
{
    die("Panel does not exist.");
}

while ($row = mysqli_fetch_array($result))
{
    $secret = $row['secret'];
	$_SESSION['panelapp'] = $secret;
	$panelStatus = $row['panelstatus'];
	$_SESSION["panelname"] = $row["name"];
}

if(!$panelStatus)
{
      die("Panel was disabled by the application owner");
}

$result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$owner' AND `role` = 'seller'");

if (mysqli_num_rows($result) == 0)
{
    die("Tell the application owner they need to upgrade to seller to utilize customer panel!");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
echo '
	    <title>KeyAuth - Login to ' . $username . ' Panel</title>
	    <meta name="og:image" content="https://cdn.keyauth.uk/front/assets/img/favicon.png">
        <meta name="description" content="Login to reset your HWID or download ' . $username . '">
        ';
?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://cdn.keyauth.uk/assets/img/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<link href="../../app/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="../../app/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<body id="kt_body" class="bg-dark">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<a href="../../" class="mb-12">
						<img alt="Logo" src="../../app/assets/media/logos/favicon.ico" class="h-40px" />
					</a>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form class="form w-100" method="post">
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-light mb-3"><?php echo 'Login To ' . $username . ' Panel'; ?></h1>
								<!--end::Title-->
								
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-light">Username</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="keyauthusername" autocomplete="on" />
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
								<input class="form-control form-control-lg form-control-solid" type="password" name="keyauthpassword" autocomplete="on" />
								<!--end::Input-->
							</div>
							<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-5">New Here?
								<a href="../register/" class="link-primary fw-bolder">Create an Account</a></div>
								<br>
								<div class="text-gray-400 fw-bold fs-5">Upgrade?
								<a href="../upgrade/" class="link-primary fw-bolder">Upgrade Account</a></div>
								<!--end::Link-->
								<br>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button name="login" class="btn btn-lg btn-primary w-100 mb-5">
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
if (isset($_POST['login']))
{
    if (empty($_POST['keyauthusername']) || empty($_POST['keyauthpassword']))
    {

        error("You must fill in all the fields!");
        return;
    }

    $un = misc\etc\sanitize($_POST['keyauthusername']);
    $password = misc\etc\sanitize($_POST['keyauthpassword']);

    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$un' AND `app` = '$secret'");

    if (mysqli_num_rows($result) < 1)
    {
        error("User not found!");
    }
    else if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result))
        {
            $pass = $row['password'];
            $banned = $row['banned'];
        }

        if (!is_null($banned))
        {
            error("Banned: Reason: " . misc\etc\sanitize($banned));
            return;
        }

        if (!password_verify($password, $pass))
        {
            error("Password is invalid!");
            return;
        }
		
		$result = mysqli_query($link, "SELECT `id` FROM `subs` WHERE `user` = '$un' AND `expiry` > '".time()."' AND `app` = '$secret'");
		if (mysqli_num_rows($result) === 0)
		{
			error("You have no active subscriptions! You you change this by clicking upgrade");
		}
		else
		{
        $_SESSION['un'] = $un;
        header("location: ../dashboard/");
		}
	}
}
?>
</body>
</html>