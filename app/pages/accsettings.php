<?php

include '../includes/connection.php';
include '../includes/functions.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}

	        $username = $_SESSION['username'];

            ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));

            $row = mysqli_fetch_array($result);

            

			if($username == "demodeveloper" || $username == "demoseller")
			{
				die("OwnerID: " . $row['ownerid'] . "<br>that's the only thing you need on this page.");
			}
			
            $banned = $row['banned'];

			$lastreset = $row['lastreset'];

			if (!is_null($banned) || $_SESSION['logindate'] < $lastreset)
			{
				echo "<meta http-equiv='Refresh' Content='0; url=../auth/login.php'>";
				session_destroy();
				exit();
			}
            $role = $row['role'];
            $twofactor = $row['twofactor'];
            $_SESSION['role'] = $role;
            
if ($role == "Reseller")
{
    die('Resellers Not Allowed Here');
}

?>



<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
<?php

        ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '".$_SESSION['username']."'")) or die(mysqli_error($link));

        if (mysqli_num_rows($result) > 0)

            {

                while ($row = mysqli_fetch_array($result))

                {

                    $darkmode = (($row['darkmode'] ? 1 : 0) ? 'Disabled' : 'Enabled');

                    

                    $acclogs = (($row['acclogs'] ? 0 : 1) ? 'Disabled' : 'Enabled');

                    

                    $expiry = date('jS F Y h:i:s A (T)', $row["expires"]);

                }

            }

?>

<div class="row">

<div class="col-12">

    <div class="card">

        <div class="card-body">


                <div class="form-group row">

                    <label for="example-text-input" class="col-2 col-form-label">Username</label>

                    <div class="col-10">

                        <label class="form-control"><?php echo $_SESSION['username']; ?></label>

                    </div>

                </div>
                <br>

                <div class="form-group row">

                    <label for="example-text-input" class="col-2 col-form-label">OwnerID</label>

                    <div class="col-10">

                        <label class="form-control"><?php echo $_SESSION['ownerid']; ?></label>

                    </div>

                </div>
                <br>

                <div class="form-group row">

                    <label for="example-text-input" class="col-2 col-form-label">Subscription Expires</label>

                    <div class="col-10">

                        <label class="form-control"><?php echo $expiry; ?></label>

                    </div>

                </div>
                <br>

                <div class="form-group row">

                    <label for="example-tel-input" class="col-2 col-form-label">Account logs</label>

                    <div class="col-10">

                        <select class="form-control" name="acclogs"><option><?php echo $acclogs; 

                                

                                if($acclogs == "Enabled")

                                {

                                    echo"<option>Disabled</option>";

                                }

                                else

                                {

                                    echo"<option>Enabled</option>";

                                }

                                

                                ?></option></select>

                    </div>

                </div>
                <br>

                <div class="form-group row">

                    <label for="example-tel-input" class="col-2 col-form-label">Password</label>

                    <div class="col-10">

                        <input class="form-control" type="password" name="pw" placeholder="Enter new password to change to">

                    </div>

                </div>
                <br>

                <div class="form-group row">

                    <label for="example-password-input" class="col-2 col-form-label">Profile Image</label>

                    <div class="col-10">

                        <input class="form-control" name="pfp" type="url" placeholder="Enter link to image for profile picture">

                    </div>

                </div>
                <br>

                <div class="form-group row">

                    <label for="example-password-input" class="col-2 col-form-label">Email</label>

                    <div class="col-10">

                        <input class="form-control" name="email" type="email" placeholder="Change email address">

                    </div>

                </div>
                <br>

                <div class="form-group row">

                    <label for="example-password-input" class="col-2 col-form-label">Username</label>

                    <div class="col-10">

                        <input class="form-control" name="username" placeholder="Change username">

                    </div>

                </div>
                <br>

                <form method="POST">
                <button name="updatesettings" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>  
                <a type="button" class="btn btn-info"target="popup" onclick="window.open('https://discord.com/api/oauth2/authorize?client_id=866538681308545054&redirect_uri=https%3A%2F%2F<?php echo ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']); ?>%2Fapi%2Fdiscord%2F&response_type=code&scope=identify%20guilds.join','popup','width=600,height=600'); return false;"> <i class="fab fa-discord"></i>  Link Discord</a>  
                <?php if($twofactor == 0){echo '                <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#twofa"><i class="fa fa-lock"></i>Enable 2FA</a>';}else{echo'                <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#disabletwofa"><i class="fa fa-lock"></i>Disable 2FA</a>';}?>  
                <button name="refreshownerid" class="btn btn-warning" onclick="return confirm('Are you sure you want to reset ownerid for your account and all your applications?')"> <i class="fa fa-check"></i> Refresh OwnerID</button>

                </form>



            <!--begin::Modal - 2fa App-->
		<div class="modal fade" id="twofa" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">2 Factor Authentication</h2>
<?php
    require_once '../includes/GoogleAuthenticator.php';
    $gauth = new GoogleAuthenticator();
    $code_2factor = $gauth->createSecret();
    $integrate_code = mysqli_query($link, "UPDATE `accounts` SET `googleAuthCode` = '$code_2factor' WHERE `username` = '".$_SESSION['username']."'") or die(mysqli_error($link));
    $google_QR_Code = $gauth->getQRCodeGoogleUrl($_SESSION['username'], $code_2factor, 'KeyAuth');

?>

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
													<span class="required">2FA Code</span>
												</label>
												<!--end::Label-->
												<!--begin::Input-->
                                                <label>Scan this QR code into your 2FA App.</label>
                                                        <img src="<?php $google_QR_Code ?>" />
                                                        </br>
                                                        </br>
                                                        <label>Alternatively, you can set it manually, code: <?php $code_2factor ?></label>
                                                <input type="text" name="scan_code" id="scan_code" maxlength="6" placeholder="6 Digit Code from 2FA app" class="form-control mb-4" required>
												<!--end::Input-->
											</div>
											<!--end::Input group-->	
										</div>
									</div>
										<div class="modal-footer">
											<button name="submit_code" class="btn btn-primary">Submit</button>
										</div>
            					</div>
						</form>
					<!--end::Modal header-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - 2fa App-->

         <!--begin::Modal - disable 2fa App-->
		<div class="modal fade" id="disabletwofa" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Disable 2 Factor Authentication</h2>

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
													<span class="required">2FA Code</span>
												</label>
												<!--end::Label-->
												<!--begin::Input-->
                                                <input type="text" name="scan_code" id="scan_code" maxlength="6" placeholder="6 Digit Code from 2FA app" class="form-control mb-4" required>
												<!--end::Input-->
											</div>
											<!--end::Input group-->	
										</div>
									</div>
										<div class="modal-footer">
											<button name="submit_code_disable" class="btn btn-primary">Submit</button>
										</div>
            					</div>
						</form>
					<!--end::Modal header-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - disable 2fa App-->



        
            <?php



                                             
                



                        ?>

        </div>

    </div>

</div>

</div>

<!-- Show / hide columns dynamically -->



<!-- Column rendering -->



<!-- Row grouping -->



<!-- Multiple table control element -->



<?php



if(isset($_POST['refreshownerid']))

{

$ownerid = generateRandomString();



mysqli_query($link, "UPDATE `accounts` SET `ownerid` = '$ownerid' WHERE `username` = '".$_SESSION['username']."'");

mysqli_query($link, "UPDATE `apps` SET `ownerid` = '$ownerid' WHERE `owner` = '".$_SESSION['username']."'");



$_SESSION['ownerid'] = $ownerid;



if(mysqli_affected_rows($link) != 0)

{

success("Successfully Refreshed OwnerID!");

echo "<meta http-equiv='Refresh' Content='2;'>";         

}

else

{

error("OwnerID Refresh Failed!");

echo "<meta http-equiv='Refresh' Content='2;'>";

}

}

    

if(isset($_POST['updatesettings']))



{



    $pw = sanitize($_POST['pw']);



    $pfp = sanitize($_POST['pfp']);

    

    $email = sanitize($_POST['email']);

    

    $username = sanitize($_POST['username']);

    

    $darkmode = sanitize($_POST['darkmode']);

    

    $acclogs = sanitize($_POST['acclogs']);

    

    $darkmode = $darkmode == "Enabled" ? 0 : 1;

    $acclogs = $acclogs == "Disabled" ? 0 : 1;

    mysqli_query($link, "UPDATE `accounts` SET `darkmode` = '$darkmode',`acclogs` = '$acclogs' WHERE `username` = '".$_SESSION['username']."'");

    

    if($acclogs == 0)

    {

        mysqli_query($link, "DELETE FROM `acclogs` WHERE `username` = '" . $_SESSION['username'] . "'"); // delete all account logs

    }

    

    if(isset($email) && trim($email) != '')



    {

        ($result = mysqli_query($link, "SELECT `email` FROM `accounts` WHERE `email` = '$email'")) or die(mysqli_error($link));

        if (mysqli_num_rows($result) != 0)

        {

            error("Another account is already using this email!");

            echo "<meta http-equiv='Refresh' Content='2;'>";  

            return;

        }

        

        mysqli_query($link, "UPDATE `accounts` SET `email` = '$email' WHERE `username` = '".$_SESSION['username']."'");

        

        if (mysqli_affected_rows($link) != 0)

        {	

            wh_log($logwebhook,"".$_SESSION['username']." with email " . $_SESSION['email'] . " has changed email to `{$email}`", $webhookun);

            

            $_SESSION['email'] = $email;

        }



    }

    

    if(isset($username) && trim($username) != '')



    {

        

        if($username == $_SESSION['username'])

        {

            error("You already occupy this username!");

            echo "<meta http-equiv='Refresh' Content='2;'>";  

            return;

        }

        

        ($result = mysqli_query($link, "SELECT `username` FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));

        if (mysqli_num_rows($result) != 0)

        {

            error("Another account is already using this username!");

            echo "<meta http-equiv='Refresh' Content='2;'>";  

            return;

        }

        

        mysqli_query($link, "UPDATE `acclogs` SET `username` = '$username' WHERE `username` = '".$_SESSION['username']."'");

        mysqli_query($link, "UPDATE `apps` SET `owner` = '$username' WHERE `owner` = '".$_SESSION['username']."'");

        mysqli_query($link, "UPDATE `keys` SET `genby` = '$username' WHERE `genby` = '".$_SESSION['username']."'");

        

        mysqli_query($link, "UPDATE `accounts` SET `username` = '$username' WHERE `username` = '".$_SESSION['username']."'");

        

        if (mysqli_affected_rows($link) != 0)

        {

            wh_log($logwebhook,"".$_SESSION['username']." has changed username to `{$username}`", $webhookun);

            

            $_SESSION['username'] = $username;

        }



    }

    

    if(isset($pw) && trim($pw) != '')



    {



        $pass_encrypted = password_hash($pw, PASSWORD_BCRYPT);



        mysqli_query($link, "UPDATE `accounts` SET `password` = '$pass_encrypted' WHERE `username` = '".$_SESSION['username']."'");



    }



    



    if(isset($_POST['pfp']) && trim($_POST['pfp']) != '')



    {

        if (!filter_var($pfp, FILTER_VALIDATE_URL)) { 

        error("Invalid Url For Profile Image!");

        return;

        }



        $_SESSION['img'] = $pfp;



        mysqli_query($link, "UPDATE `accounts` SET `img` = '$pfp' WHERE `username` = '".$_SESSION['username']."'");



    }







                            echo '
    <script type=\'text/javascript\'>
    
    const notyf = new Notyf();
    notyf
      .success({
        message: \'Updated Account Settings!\',
        duration: 3500,
        dismissible: true
      });                
    
    </script>
    ';



    echo "<meta http-equiv='Refresh' Content='2;'>";  



}







if (isset($_POST['submit_code']))



                                                    {



                                                        if (empty($_POST['scan_code']))



                                                        {



                                                            



                                                            



                                                            echo '
                                                                <script type=\'text/javascript\'>
                                                                                
                                                                const notyf = new Notyf();
                                                                notyf
                                                                .error({
                                                                    message: \'You must fill in all the fields!\',
                                                                    duration: 3500,
                                                                    dismissible: true
                                                                });                
                                                                                
                                                            </script>
                                                            ';          



                        



                        



                                                        }



                                                        



                                                        $code = sanitize($_POST['scan_code']);



                                                        



                                                        $user_result = mysqli_query($link, "SELECT * from `accounts` WHERE `username` = '".$_SESSION['username']."'") or die(mysqli_error($link));



                                                        while ($row = mysqli_fetch_array($user_result))



                                                        {



                                                            $secret_code = $row['googleAuthCode'];



                                                        }



                                                        



                                                        $checkResult = $gauth->verifyCode($secret_code, $code, 2);



                                                        



                                                        if ($checkResult)



                                                        {



                                                            



                                                            $enable_2factor = mysqli_query($link, "UPDATE `accounts` SET `twofactor` = '1' WHERE `username` = '".$_SESSION['username']."'") or die(mysqli_error($link));



                                                            



                                                            if ($enable_2factor)



                                                            {          







                                                                echo '
                                                                    <script type=\'text/javascript\'>
                                                                                    
                                                                    const notyf = new Notyf();
                                                                    notyf
                                                                    .success({
                                                                        message: \'Two-factor security has been successfully activated on your account!\',
                                                                        duration: 3500,
                                                                        dismissible: true
                                                                    });                
                                                                                    
                                                                </script>
                                                                ';                                                                                          

                                                                echo "<meta http-equiv='Refresh' Content='2;'>";

                                                            



                                                            }



                                                            else



                                                            {



                                                                



                                                                



                                                                echo '
                                                                    <script type=\'text/javascript\'>
                                                                                    
                                                                    const notyf = new Notyf();
                                                                    notyf
                                                                    .error({
                                                                        message: \'There was a problem trying to activate security on your account!\',
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
                                                                    message: \'The code entered is incorrect\',
                                                                    duration: 3500,
                                                                    dismissible: true
                                                                });                
                                                                                    
                                                            </script>
                                                            ';                      



                                                                



                                                        }



                                                        



                                                    }

                                                    

                                                    

                                                    

                                                    

                                                    

                                                    

                                                    if (isset($_POST['submit_code_disable']))



                                                    {



                                                        if (empty($_POST['scan_code']))



                                                        {



                                                            



                                                            



                                                            echo '
                                                                <script type=\'text/javascript\'>
                                                                                
                                                                const notyf = new Notyf();
                                                                notyf
                                                                .error({
                                                                    message: \'You must fill in all the fields!\',
                                                                    duration: 3500,
                                                                    dismissible: true
                                                                });                
                                                                                
                                                            </script>
                                                            ';          



                        



                        



                                                        }



                                                        



                                                        $code = sanitize($_POST['scan_code']);



                                                        



                                                        $user_result = mysqli_query($link, "SELECT * from `accounts` WHERE `username` = '".$_SESSION['username']."'") or die(mysqli_error($link));



                                                        while ($row = mysqli_fetch_array($user_result))



                                                        {



                                                            $secret_code = $row['googleAuthCode'];



                                                        }



                                                        



                                                        $checkResult = $gauth->verifyCode($secret_code, $code, 2);



                                                        



                                                        if ($checkResult)



                                                        {



                                                            



                                                            $enable_2factor = mysqli_query($link, "UPDATE `accounts` SET `twofactor` = '0' WHERE `username` = '".$_SESSION['username']."'") or die(mysqli_error($link));



                                                            



                                                            if ($enable_2factor)



                                                            {          







                                                                echo '
                                                                    <script type=\'text/javascript\'>
                                                                                    
                                                                    const notyf = new Notyf();
                                                                    notyf
                                                                    .success({
                                                                        message: \'Two-factor security has been successfully disabled on your account!\',
                                                                        duration: 3500,
                                                                        dismissible: true
                                                                    });                
                                                                                    
                                                                </script>
                                                                ';                                                                                          

                                                                echo "<meta http-equiv='Refresh' Content='2;'>";	

                                                            



                                                            }



                                                            else



                                                            {



                                                                



                                                                



                                                                echo '
                                                                    <script type=\'text/javascript\'>
                                                                                    
                                                                    const notyf = new Notyf();
                                                                    notyf
                                                                    .error({
                                                                        message: \'There was a problem trying to activate security on your account!\',
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
                                                                    message: \'The code entered is incorrect\',
                                                                    duration: 3500,
                                                                    dismissible: true
                                                                });                
                                                                                    
                                                            </script>
                                                            ';                      



                                                                



                                                        }



                                                        



                                                    }



?>

	
</div>
<!--end::Container-->
