<?php
include 'includes/connection.php';
include 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']))
{
    header("Location: auth/login.php");
    exit();
}

$username = $_SESSION["username"];

($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));

    if (mysqli_num_rows($result) == 0)
    {
       error("Account doesn\'t exist!");
        return;
    }
    while ($row = mysqli_fetch_array($result))
    {
        $id = $row['ownerid'];
        $email = $row['email'];
        $role = $row['role'];
        $img = $row['img'];
        $owner = $row['owner'];
    }


$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['ownerid'] = $id;
$_SESSION['owner'] = $owner;
$_SESSION['role'] = $role;
$_SESSION['logindate'] = time();
$_SESSION['img'] = $img;


?>

<!DOCTYPE html>
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
		<meta property="og:image" content="https://cdn.keyauth.com/front/assets/img/favicon.png" />
		<meta property=”og:site_name” content="KeyAuth | Secure your software from piracy." />

		<!-- Schema.org markup for Google+ -->
		<meta itemprop="name" content="KeyAuth - Open Source Auth">
		<meta itemprop="description" content="Secure your software against piracy, an issue causing $422 million in losses anually - Fair pricing & Features not seen in competitors">

		<meta itemprop="image" content="https://cdn.keyauth.com/front/assets/img/favicon.png">

		<!-- Twitter Card data -->
		<meta name="twitter:card" content="product">
		<meta name="twitter:site" content="@keyauth">
		<meta name="twitter:title" content="KeyAuth - Open Source Auth">

		<meta name="twitter:description" content="Secure your software against piracy, an issue causing $422 million in losses anually - Fair pricing & Features not seen in competitors">
		<meta name="twitter:creator" content="@keyauth">
		<meta name="twitter:image" content="https://cdn.keyauth.com/front/assets/img/favicon.png">


		<!-- Open Graph data -->
		<meta property="og:title" content="KeyAuth - Open Source Auth" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="./" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
			<link href="assets/plugins/global/plugins.dark.bundle.css" rel="stylesheet" type="text/css" />
			<link href="assets/css/style.dark.bundle.css" rel="stylesheet" type="text/css" />';
	
		
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->

	<!--<body id="kt_body" class="page-loading-enabled header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px" data-kt-aside-minimize="on">'; -->
<body id="kt_body" class="page-loading-enabled header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px"';
<?php include 'layout/master.php' ?>


<?php include 'layout/engage/_main.php' ?>


<?php include 'layout/_scrolltop.php' ?>

		<!--end::Modals-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<script src="assets/plugins/custom/datatables/datatables.js"></script>
		<!--end::Page Vendors Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>