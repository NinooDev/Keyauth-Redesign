<?php

include '../../app/includes/connection.php';
require '../../app/includes/misc/autoload.phtml';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['un'])) {
    die("not logged in");
}

$result = mysqli_query($link, "SELECT * FROM `apps` WHERE `secret` = '".$_SESSION['panelapp']."'");
            $row = mysqli_fetch_array($result);
			
			$name = $row["name"];
			$download = $row["download"];
			$webdownload = $row["webdownload"];
			$appcooldown = $row["cooldown"];

    

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 4 admin, bootstrap 4, css3 dashboard, bootstrap 4 dashboard, xtreme admin bootstrap 4 dashboard, frontend, responsive bootstrap 4 admin template, material design, material dashboard bootstrap 4 dashboard template">
    <meta name="description" content="Xtreme is powerful and clean admin dashboard template, inpired from Google's Material Design">
    <meta name="robots" content="noindex,nofollow">
    <title><?php echo $name; ?> Panel</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="https://cdn.keyauth.uk/static/images/favicon.png">
	<script src="https://cdn.keyauth.uk/dashboard/assets/libs/jquery/dist/jquery.min.js"></script>
    <link href="../../app/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="../../app/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	

	<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
	<script src="https://cdn.keyauth.uk/dashboard/unixtolocal.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">



	                    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
  
           						

           	
    <body id="kt_body" class="bg-dark">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form class="form w-100" method="post">
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<button name="logout" class="btn btn-sm btn-primary mb-1">Logout</button>
        									<span class="indicator-progress">Please wait...
								            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							           	   </button>
							           	   <br><br>
								<h1 class="text-light mb-3">Dashboard</h1>
								<!--end::Title-->
							</div>
						
						    <div class="form-group row">
                                        <h2 class="text-light mb-3">Application Download</h2>
                                        <div class="col-10">
                                           <button name="download" class="btn btn-sm btn-primary mb-">
        									<i class="fas fa-download fa-sm text-white-50"></i> Download</button>
        									<span class="indicator-progress">Please wait...
								            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							           	   </button>
                                        </div>
                            </div>
                                        <br>
                                        <?php
                                        $result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '".$_SESSION['panelapp']."' AND `username` = '".$_SESSION['un']."'");

                            

                            $row = mysqli_fetch_array($result);

                            $today = time();

                            $cooldown = $row["cooldown"];

                            if(is_null($cooldown))

                            {

                            echo'<form method="post">
                            <button name="resethwid" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-redo-alt fa-sm text-white-50"></i> Reset HWID</button></form>';   

                            }

                            else

                            {

                            if ($today > $cooldown)

                            {

                            echo'<form method="post">
                            <button name="resethwid" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-redo-alt fa-sm text-white-50"></i> Reset HWID</button></form>';

                            }

                            else

                            {

                                echo '<div style="color:red;">You can\'t reset HWID again until <script>document.write(convertTimestamp('.$cooldown.'));</script></div>';

                            }

                            }

                        ?>
                        <br><br>
                        <?php if (!is_null($webdownload)) { ?>
					
                                <h2 class="text-light mb-1">Web Loader</h2>
                                <br>
								<br>
								<div class="col-10" style="display:none;" id="buttons">
                                            <?php
											($result = mysqli_query($link, "SELECT * FROM `buttons` WHERE `app` = '".$_SESSION['panelapp']."'")) or die(mysqli_error($link));
											$rows = array();
											while ($r = mysqli_fetch_assoc($result))
											{
												$rows[] = $r;
											}
									
											foreach ($rows as $row)
											{
											?>
											<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="doButton(this.value)"value="<?php echo $row['value']; ?>"><?php echo $row['text']; ?></button>
											<?php
											}
											?>
								</div>
								<div class="col-10" id="handshake">
								<a onclick="handshake()" href="<?php echo $webdownload; ?>" style="color:white;" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Download</a>
								</div>
							
						<?php } ?>
                    </div>
						
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
    
                
                
                
                
    
     <?php
     
      if (isset($_POST['download']))
        {
            ?>
            <meta http-equiv="refresh" content="0;url= <?php echo $download; ?>">
            <?php
            
        }
        if (isset($_POST['logout']))
        {
            ?>
            <meta http-equiv="refresh" content="0;url=./logout.php">
            <?php
            
        }
        if (isset($_POST['resethwid']))

        {

        $today = time();

        $cooldown = $today + $appcooldown;

        mysqli_query($link, "UPDATE `users` SET `hwid` = '', `cooldown` = '$cooldown' WHERE `app` = '".$_SESSION['panelapp']."' AND `username` = '".$_SESSION['un']."'");

        success("Reset HWID!");
        echo "<meta http-equiv='Refresh' Content='2;'>";   

        }

        ?>
        
		
          
    <script>
	<?php
			$result = mysqli_query($link, "SELECT `password` FROM `users` WHERE `username` = '".$_SESSION['un']."' AND `app` = '".$_SESSION['panelapp']."'");
            $row = mysqli_fetch_array($result);
			
			$token = md5(substr($row["password"], -5));
			// $token = "aa";
	?>
	var going = 1;
	function handshake()
	{
		setTimeout(function() { 
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", "http://localhost:1337/handshake?user=<?php echo $_SESSION['un']; ?>&token=<?php echo $token; ?>");
		xmlHttp.onload = function () {
			going = 0;
			switch(xmlHttp.status) {
				case 420:
					console.log("returned SHEESH :)");
					$("#handshake").fadeOut(100);
					$("#buttons").fadeIn(1900);
					break;
				default:
					alert(xmlHttp.statusText);
					break;
			}
		};
		xmlHttp.send();
			if (going == 1) {
			handshake();
			}
		}, 3000)
	}
	function doButton(value)
	{
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", "http://localhost:1337/" + value);
		xmlHttp.send();
	}
	</script>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    
  

    <!--Custom JavaScript -->
   <script src="https://cdn.keyauth.uk/dashboard/dist/js/feather.min.js"></script>
    <script src="https://cdn.keyauth.uk/dashboard/dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
  
  
</body>
</html>