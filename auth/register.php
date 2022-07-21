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

<html lang="en">
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
			<!--begin::Authentication - Sign-up -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14-dark.png">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<a href="../" class="mb-12">
						<img alt="Logo" src="../assets/media/logos/favicon.ico" class="h-40px" />
					</a>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form class="form w-100" id="kt_sign_up_form" method="post">
							<!--begin::Heading-->
							<div class="mb-10 text-center">
								<!--begin::Title-->
								<h1 class="text-light mb-3">Create an Account</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Already have an account?
								<a href="login.php" class="link-primary fw-bolder">Sign in here</a></div>
								<!--end::Link-->
							</div>
							<!--end::Heading-->
							
							
							<!--begin::Input group-->
							<div class="fv-row mb-7">
								<!--begin::Col-->
									<label class="form-label fw-bolder text-light fs-6">Username</label>
									<input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="username" autocomplete="on" />
								<!--end::Col-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-7">
								<label class="form-label fw-bolder text-light fs-6">Email</label>
								<input class="form-control form-control-lg form-control-solid" type="email" placeholder="" name="email" autocomplete="on" />
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="mb-10 fv-row" data-kt-password-meter="true">
								<!--begin::Wrapper-->
								<div class="mb-1">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-light fs-6">Password</label>
									<!--end::Label-->
									<!--begin::Input wrapper-->
									<div class="position-relative mb-3">
										<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="on" />
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
											<i class="bi bi-eye-slash fs-2"></i>
											<i class="bi bi-eye fs-2 d-none"></i>
										</span>
									</div>
									<!--end::Input wrapper-->
									<!--begin::Meter-->
									<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
									</div>
									<!--end::Meter-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Hint-->
								<div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
								<!--end::Hint-->
							</div>
							<!--end::Input group=-->
							<!--begin::Input group-->
							<div class="fv-row mb-5">
								<label class="form-label fw-bolder text-light fs-6">Confirm Password</label>
								<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm-password" autocomplete="off" />
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-check form-check-custom form-check-solid form-check-inline">
									<input class="form-check-input" type="checkbox" name="toc" />
									<span class="form-check-label fw-bold text-gray-700 fs-6">I agree to the
									<a data-bs-toggle="modal" data-bs-target="#terms" class="ms-1 link-primary">Terms of Service</a> and
									<a data-bs-toggle="modal" data-bs-target="#privacy" class="ms-1 link-primary">Privacy Policy</a>.</span>
								</label>
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<button name="signup" class="btn btn-lg btn-primary">
									<span class="indicator-label">Submit</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
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
			<!--end::Authentication - Sign-up-->
		</div>
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="../assets/plugins/global/plugins.bundle.js"></script>
		<script src="../assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->


<div class="modal fade" tabindex="-1" id="terms">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-light">Privacy Policy</h1>

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

            <div class="modal-body text-light">
            <p>This may be modified at any time without further consent of the user.
			Property of Nelson Cybersecurity LLC. Headquartered in Florida, hosted in New York.</p>

			<h1 class="text-light">Copyright</h1>
			<p>We don't host any of our user's files, downloading via our API acts as a proxy and the files are never stored on the server's disk. Given this, you must contact the file host and notify them of the alleged infringement.</p>

			<h1 class="text-light">Account</h1>
			<p>Account owners have the sole responsibility for their credentials, we are not responsible for the loss, leaking, and use of these credentials unless through a security breach on our platform. We make available numerous options to protect or recover your account, including 2FA and Password Resets. Accounts are for individual use only, any multiple-party use is prohibited and may result in the termination of your account.</p>

			<h1 class="text-light">Applications</h1>
			<p>You are responsible for the content uploaded or that communicates with KeyAuth. While we will remove illegal content if we're made aware of it, "KeyAuth" is provided immunity from any legal action held against anything uploaded by users on our service (KeyAuth 230 of the Communications Decency Act). Emails from law enforcement or legal counsel regarding illegal content using our service should be directed to EMAIL.</p>

			<h1 class="text-light">Acceptable Use</h1>
			<p>You agree to comply with all applicable legislation and regulations in connection with your use of KeyAuth, this is not limited to your local laws. The use of our service to host, transmit, or share any illegal data will result in an immediate termination of your account and a possible law enforcement notification. We also forbid any attempt to abuse, spam, hack, or crack our service without the written permission of Nelson Cybersecurity LLC. The following actions will result in account termination:</p>

			<span class="bullet bullet-dot me-5"></span><p>	Attacks against our webserver, including DDoS attacks and exploitative attempts.</p>

			<span class="bullet bullet-dot me-5"></span><p>	Creating a dispute after the refund period, seven days.</p>

			<span class="bullet bullet-dot me-5"></span><p>	Attempting to libel KeyAuth to hurt its reputation.</p>

			<span class="bullet bullet-dot me-5"></span><p>	Utilizing an unreasonable amount of server resources, i.e. creating hundreds of thousands of users.</p>

			<span class="bullet bullet-dot me-5"></span><p>	Violating KeyAuth's open-source license, i.e monetarily benefitting from KeyAuth source by selling it as if you own it</p>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="privacy">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-light">Privacy Policy</h1>

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

			<div class="modal-body text-light">

			<h1 class="text-light">Privacy</h1>
			<p>It is pretty much necessary to store these details to fight fraudulent disputes. Otherwise, we'll have insufficient evidence to win the dispute. Also I highly recommend you use the password manager https://bitward.com. You can use Bitwarden for free on multiple devices, and you can also purchase their premium to unlock the ability to store 2FA codes in their browser extension or mobile app.

			<p>We collect the below-listed details. We'll try to keep this updated, you can also view https://github.com/KeyAuth/KeyAuth-Source-Code/blob/main/db_structure.sql</p>

			<span class="bullet bullet-dot me-5"></span><p>	IP address used to register account, last IP address to login to account, and only if account logs are enabled on your account (they are by default), every IP address that has logged into your account in the past week is saved in database. Also, regardless of whether account logs are enabled, every IP address used to login to an account is sent to a private Discord webhook.</p>

			<span class="bullet bullet-dot me-5"></span><p>	Passwords are hashed with BCrypt prior to being stored in the database. We do not log plain-text passwords. With today's technology, BCrypt passwords are considered unable to decrypt to their plain-text form.</p>

			<span class="bullet bullet-dot me-5"></span><p>	Email used to register is stored in database, 2FA secret is stored if enabled.</p>

			<span class="bullet bullet-dot me-5"></span><p>	Your customer's Windows SID (hwid) is stored in database if sent to our API, their IP address is stored, and their password is stored after being hashed with BCrypt. You're unable to get your customer's plain-text password from our server.</p>

			<span class="bullet bullet-dot me-5"></span><p>	We use E-commerce platforms to handle our payments. From the orders on those platforms, we can identify which person made the order. Though, we do not store any of your payment information in our database.</p>


			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        <?php
            if (isset($_POST['signup']))
        {

            $username = sanitize($_POST['username']);

            $password = sanitize($_POST['password']);

			$confpassword = sanitize($_POST['confirm-password']);

            $email = sanitize($_POST['email']);

			$toc = sanitize($_POST['toc']);

			if($username == "" || $password == "" || $confpassword == "" || $email == "")
			{
				error("Missing Information!");
				return;
			}
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			$number    = preg_match('@[0-9]@', $password);
			$specialChars = preg_match('@[^\w]@', $password);
			if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) 
			{
				error("Password too weak!");
				return;
			}


			if($confpassword != $password)
			{
				error("Passwords do not match!");
				return;
			}

			if($toc != "on")
			{
				error("Accept the Terms of Service and Privacy Policy!");
				return;
			}

            $result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'") or die(mysqli_error($link));

            if (mysqli_num_rows($result) == 1)
            {
                error("Username already taken!");
                return;
            }

            $email_check = mysqli_query($link, "SELECT * FROM `accounts` WHERE `email` = '$email'") or die(mysqli_error($link));
            $do_email_check = mysqli_num_rows($email_check);
            if ($do_email_check > 0)
            {
                error('Email already used by username: ' . mysqli_fetch_array($email_check) ['username'] . '');
                return;
            }
            
            $pass_encrypted = password_hash($password, PASSWORD_BCRYPT);

            $ownerid = generateRandomString();

            mysqli_query($link, "INSERT INTO `accounts` (`username`, `email`, `password`, `ownerid`, `role`, `img`,`balance`, `expires`, `registrationip`) VALUES ('$username', '$email', '$pass_encrypted', '$ownerid','tester','https://cdn.keyauth.com/front/assets/img/favicon.png','1', NULL, '$ip')") or die(mysqli_error($link));

            $_SESSION['logindate'] = time();
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['ownerid'] = $ownerid;
            $_SESSION['role'] = 'tester';
            $_SESSION['img'] = 'https://cdn.keyauth.uk/front/assets/img/favicon.png';
			success("Account created!");
            mysqli_close($link);
			echo "<meta http-equiv='Refresh' Content='1; url=../'>"; 
            
        }

?> 
	</body>
	<!--end::Body-->
</html>