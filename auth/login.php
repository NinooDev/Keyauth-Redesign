<?php
include '../includes/connection.php';
include '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username']))
{
    header("Location: ../");
    exit();
}
?>

<html>
	<!--begin::Head-->
	<head><base href="">
		<title>Keyauth - Open Source Auth</title>
		<meta charset="utf-8" />
		<!-- Canonical SEO -->
		<link rel="canonical" href="https://keyauth.com" />

		<meta content="Secure your software against piracy, an issue causing $422 million in losses anually - Fair pricing & Features not seen in competitors" name="description" />
		<meta content="KeyAuth" name="author" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="KeyAuth, Cloud Authentication, Key Authentication,Authentication, API authentication,Security, Encryption authentication, Authenticated encryption, Cybersecurity, Developer, SaaS, Software Licensing, Licensing" />
		<meta property=”og:description” content="Secure your software against piracy, an issue causing $422 million in losses anually - Fair pricing & Features not seen in competitors" />
		<meta property="og:image" content="https://cdn.keyauth.uk/front/assets/img/favicon.png" />
		<meta property=”og:site_name” content="KeyAuth | Secure your software from piracy." />

		<!-- Schema.org markup for Google+ -->
		<meta itemprop="name" content="KeyAuth - Open Source Auth">
		<meta itemprop="description" content="Secure your software against piracy, an issue causing $422 million in losses anually - Fair pricing & Features not seen in competitors">

		<meta itemprop="image" content="https://cdn.keyauth.uk/front/assets/img/favicon.png">

		<!-- Twitter Card data -->
		<meta name="twitter:card" content="product">
		<meta name="twitter:site" content="@keyauth">
		<meta name="twitter:title" content="KeyAuth - Open Source Auth">

		<meta name="twitter:description" content="Secure your software against piracy, an issue causing $422 million in losses anually - Fair pricing & Features not seen in competitors">
		<meta name="twitter:creator" content="@keyauth">
		<meta name="twitter:image" content="https://cdn.keyauth.uk/front/assets/img/favicon.png">


		<!-- Open Graph data -->
		<meta property="og:title" content="KeyAuth - Open Source Auth" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="./" />
		<link rel="shortcut icon" href="../assets/media/logos/favicon.ico" />
		
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<style>
			/* width */
			::-webkit-scrollbar {
			width: 10px;
			}

			/* Track */
			::-webkit-scrollbar-track {
			box-shadow: inset 0 0 5px grey; 
			border-radius: 10px;
			}
			
			/* Handle */
			::-webkit-scrollbar-thumb {
			background: #2549e8; 
			border-radius: 10px;
			}

			/* Handle on hover */
			::-webkit-scrollbar-thumb:hover {
			background: #0a2bbf; 
			}
			</style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-dark">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14-dark.png">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<a href="../" class="mb-12">
						<img alt="Logo" src="../assets/media/logos/favicon.ico" class="h-40px" />
					</a>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form class="form w-100" method="post">
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-light mb-3">Sign In to Keyauth</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">New Here?
								<a href="register.php" class="link-primary fw-bolder">Create an Account</a></div>
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
									<a href="forgot.php" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="on" />
								<!--end::Input-->
							</div>
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
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-column-auto p-10">
					<!--begin::Links-->
					<div class="d-flex align-items-center fw-bold fs-6">
						<a href="https://keyauth.win" class="text-muted text-hover-primary px-2">About</a>
						<a href="mailto:support@keyauth.com" class="text-muted text-hover-primary px-2">Contact</a>
						<a href="https://discord.gg/SmDTqs3ymx" class="text-muted text-hover-primary px-2">Contact Us</a>
					</div>
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="../assets/plugins/global/plugins.bundle.js"></script>
		<script src="../assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
        <?php
if (isset($_POST['login']))
{
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));

    if (mysqli_num_rows($result) == 0)
    {
       error("Account doesn\'t exist!");
        return;
    }
    while ($row = mysqli_fetch_array($result))
    {
        $user = $row['username'];
        $pass = $row['password'];
        $id = $row['ownerid'];
        $email = $row['email'];
		$selectedapp = $row["selectedapp"];
        $role = $row['role'];
        $app = $row['app'];
        $banned = $row['banned'];
        $img = $row['img'];

        $owner = $row['owner'];
        $twofactor_optional = $row['twofactor'];
        $acclogs = $row['acclogs'];
        $google_Code = $row['googleAuthCode'];
    }

    if (!is_null($banned))
    {
        error("Banned: Reason: " . sanitize($banned));
        return;
    }

    if (!password_verify($password, $pass))
    {
       error("Password is invalid!");
        return;
    }

    if ($twofactor_optional)
    {
        // keyauthtwofactor
        $twofactor = sanitize($_POST['keyauthtwofactor']);
        if (empty($twofactor))
        {
           error("Two factor field needed for this acccount!");
            return;
        }

        require_once 'GoogleAuthenticator.php';
        $gauth = new GoogleAuthenticator();
        $checkResult = $gauth->verifyCode($google_Code, $twofactor, 2);

        if (!$checkResult)
        {
          error("2FA code Invalid!");
            return;
        }
    }
    

    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['ownerid'] = $id;
    $_SESSION['owner'] = $owner;
    $_SESSION['role'] = $role;
	$_SESSION['logindate'] = time();
	selectedapp($username);

    if ($role == "Reseller" || $role == "Manager")
    {
        ($result = mysqli_query($link, "SELECT `secret` FROM `apps` WHERE `name` = '$app' AND `owner` = '$owner'")) or die(mysqli_error($link));
        if (mysqli_num_rows($result) < 1)
        {
           error("Application you\'re assigned to no longer exists!");
            return;
        }
        while ($row = mysqli_fetch_array($result))
        {
            $app = $row["secret"];
        }
        $_SESSION['app'] = $app;
    }

    $_SESSION['img'] = $img;

    if ($acclogs) // check if account logs enabled
    
    {
		$ua = sanitize($_SERVER['HTTP_USER_AGENT']);
		$ip = getIp();
        mysqli_query($link, "INSERT INTO `acclogs`(`username`, `date`, `ip`, `useragent`) VALUES ('$username','" . time() . "','$ip','$ua')"); // insert ip log
        $ts = time() - 604800;
        mysqli_query($link, "DELETE FROM `acclogs` WHERE `username` = '$username' AND `date` < '$ts'"); // delete any account logs more than a week old
        
    }
	wh_log($logwebhook, "{$username} has logged into KeyAuth with IP `{$ip}`", $webhookun);
	
    mysqli_query($link, "UPDATE `accounts` SET `lastip` = '$ip' WHERE `username` = '$username'");

    success("Logged In!");

	echo "<meta http-equiv='Refresh' Content='1; url=../'>"; 
}
?>
        
	</body>
	<!--end::Body-->
</html>

</div>