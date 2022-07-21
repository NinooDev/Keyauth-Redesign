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

            

            $banned = $row['banned'];

			$lastreset = $row['lastreset'];

if (!is_null($banned) || $_SESSION['logindate'] < $lastreset)

			{

				echo "<meta http-equiv='Refresh' Content='0; url=../auth/login.php'>";

				session_destroy();

				exit();

			}

        

            $role = $row['role'];

            $_SESSION['role'] = $role;

			

			$darkmode = $row['darkmode'];

			

			    if($role == "Reseller" || $role == "Manager")

{

    die('Resellers or Managers Not Allowed Here');

}                           

?>
<title>KeyAuth - Upgrade</title>

<script src="https://shoppy.gg/api/embed.js"></script>

<script src="https://cdn.sellix.io/static/js/embed.js" ></script>

<link href="https://cdn.sellix.io/static/css/embed.css" rel="stylesheet" />

<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
	
<div class="row">

<div class="col-md-4 col-sm-12">

<div class="card" style="zoom: 1;">

<div class="card-body">

<div class="form-group">

<h4 class="card-title">Tester</h4>

<p><span class="bullet bullet-dot me-5"></span>Limited Keys</p>

<p><span class="bullet bullet-dot me-5"></span>File Uploads (10MB)</p>

<p><span class="bullet bullet-dot me-5"></span>Limited Logs</p>

<p><span class="bullet bullet-dot me-5"></span>No Reseller System</p>

<p><span class="bullet bullet-dot me-5"></span>Limited Support</p>

<p><span class="bullet bullet-dot me-5"></span>No Discord Role</p>

<br>

<button class="btn btn-lg btn-block font-medium btn-outline btn-outline-success btn-active-light-success block-card">Already Have</button>

</div>

</div>

</div>

</div>

<div class="col-md-4 col-sm-12">

<div class="card">

<div class="card-body">

<div class="form-group">

<h4 class="card-title">Developer</h4>

<p><span class="bullet bullet-dot me-5"></span>Unlimited Keys</p>

<p><span class="bullet bullet-dot me-5"></span>Unlimited Files (50MB each)</p>

<p><span class="bullet bullet-dot me-5"></span>Unlimited Logs</p>

<p><span class="bullet bullet-dot me-5"></span>Reseller System</p>

<p><span class="bullet bullet-dot me-5"></span>24.7.365 Support</p>

<p><span class="bullet bullet-dot me-5"></span>Discord Role</p>

<br>

<?php

			  $role = $_SESSION['role'];

			  if($role == "developer" || $role == "seller")

			  {

			  echo'<button class="btn btn-outline btn-outline-warning btn-active-light-warning block-sidenav">Already Have</button>';   

			  }

			  else

			  {

			  echo'<a data-shoppy-product="qgw9zmQ" data-shoppy-username="'.$_SESSION['username'].'" class="btn btn-lg btn-block font-medium btn-outline btn-outline-warning btn-active-light-warning block-sidenav">Purchase</a>';

			  }

			  

			  ?>

</div>

</div>

</div>

</div>

<div class="col-md-4 col-sm-12">

<div class="card">

<div class="card-body">

<div class="form-group">

<h4 class="card-title">Seller</h4>

<p><span class="bullet bullet-dot me-5"></span>All developer features</p>

<p><span class="bullet bullet-dot me-5"></span>Discord Bot</p>

<p><span class="bullet bullet-dot me-5"></span>SellerAPI (auto send sellix)</p>

<p><span class="bullet bullet-dot me-5"></span>Customer App Panel</p>

<p><span class="bullet bullet-dot me-5"></span>24.7.365 prioritzed support</p>

<p><span class="bullet bullet-dot me-5"></span>Supreme Discord Role</p>

<br>

<?php

			  $role = $_SESSION['role'];

			  if($role == "developer")

			  {

			  echo'<i>Use Coupon Code "alreadydev" for 50% off</i><br><br>'; 

			  }

			  if($role == "seller")

			  {

			  echo'<button class="btn btn-outline btn-outline-danger btn-active-light-danger block-sidenav">Already Have</button>';   

			  }

			  else

			  {

			  echo'<a data-shoppy-product="lEbrHGK" data-shoppy-username="'.$_SESSION['username'].'" class="btn btn-lg btn-block font-medium btn-outline btn-outline-danger btn-active-light-danger block-sidenav">Purchase</a>';

			  }

			  

			  ?>

</div>
</div>
</div>
</div>
</div>

</div>
<!--end::Container-->

   
