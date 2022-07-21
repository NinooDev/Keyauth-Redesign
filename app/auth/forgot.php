<?php
include '../includes/connection.php';
include '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username']))
{
    //header("Location: ../");
    //exit();
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
			<!--begin::Authentication - Password reset -->
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
								<h1 class="text-light mb-3">Forgot Password ?</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Enter your email to reset your password.</div>
								<!--end::Link-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-light fs-6">Email</label>
								<input class="form-control form-control-solid" type="email" placeholder="" name="email" autocomplete="on" />
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="d-flex flex-wrap justify-content-center pb-lg-0">
								<button name="reset" class="btn btn-lg btn-primary fw-bolder me-4">
									<span class="indicator-label">Submit</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<a href="login.php" class="btn btn-lg btn-light-primary fw-bolder">Cancel</a>
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
			<!--end::Authentication - Password reset-->
		</div>
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="../assets/plugins/global/plugins.bundle.js"></script>
		<script src="../assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->

        <?php
    if (isset($_POST['reset']))
    {
            $email = xss_clean(mysqli_real_escape_string($link, $_POST['email']));
            $result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `email` = '$email'") or die(mysqli_error($link));
            if (mysqli_num_rows($result) == 1)
            {
                
                $newPass = generateRandomString();
                $newPassHashed = password_hash($newPass, PASSWORD_BCRYPT);
                $fromName = 'KeyAuth';
                $htmlContent = ' 
                <style>html,body { padding: 0; margin:0; }</style>
                <div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#181C32">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
                        <tbody>
                            <tr>
                                <td align="center" valign="center" style="text-align:center; padding: 40px">
                                    <a href="https://keyauth.com" rel="noopener" target="_blank">
                                        <img alt="Logo" src="https://ninoodev.com/assets/favicon.ico" class="h-40px" />
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" valign="center">
                                    <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#1E1E2D; border-radius: 6px">
                                        <!--begin:Email content-->
                                        <title>KeyAuth - You Requested A Password Reset</title> 
                
                                        <div style="padding-bottom: 30px; font-size: 17px; color:white">
                                            <strong>Hello!</strong>
                                        </div>
                                        <div style="padding-bottom: 20px; color:white">Your Keyauth password was just changed.</div>
                                        <div style="padding-bottom: 40px; color:white">Here is your new password '. $newPass .'</div>
                                        <!--end:Email content-->
                                        <div style="padding-bottom: 10px; color:white ">Kind regards,
                                        <br>The Keyauth Team.
                                        <tr>
                                            <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
                                                <p>Copyright ©
                                                <a href="https://keyauth.com" rel="noopener" target="_blank">Keyauth</a>.</p>
                                            </td>
                                        </tr></br></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>'; 
                // Set content-type header for sending HTML email 
                $headers = "MIME-Version: 1.0\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8\r\n"; 
                 
                $subject = 'KeyAuth - Password Reset';
                $from = "noreply@keyauth.com";
                
                $headers .= "From:" . $from;
                    
                if (mail($email, $subject, $htmlContent, $headers))
                {
                    $update = mysqli_query($link, "UPDATE `accounts` SET `password` = '$newPassHashed' WHERE `email` = '$email'") or die(mysqli_error($link));
                    
                                echo '
                <script type=\'text/javascript\'>
                
                const notyf = new Notyf();
                notyf
                  .success({
                    message: \'Please check your email, I sent password. (Check Spam Too!)\',
                    duration: 3500,
                    dismissible: true
                  });                
                
                </script>
                ';
                    
                }
                else 
                {
                    
                                echo '
                <script type=\'text/javascript\'>
                
                const notyf = new Notyf();
                notyf
                  .error({
                    message: \'Failed to reset password. Please contact support!\',
                    duration: 3500,
                    dismissible: true
                  });                
                
                </script>
                ';     
                    
                }
            }
            else 
                {
                    
                                echo '
                <script type=\'text/javascript\'>
                
                const notyf = new Notyf();
                notyf
                  .error({
                    message: \'Failed to find account with that email\',
                    duration: 3500,
                    dismissible: true
                  });                
                
                </script>
                ';     
                    
                }
            
        }

?>

	</body>
	<!--end::Body-->
</html>