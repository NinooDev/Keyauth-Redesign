<?php

ob_start();

include '../includes/connection.php';
include '../includes/functions.php';
session_start();

if (!isset($_SESSION['username'])) {
         header("Location: ../auth/login.php");
        exit();
}


	        $username = $_SESSION['username'];
            ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));
            $row = mysqli_fetch_array($result);
        
            $role = $row['role'];
            $_SESSION['role'] = $role;
                            
?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <?php

                        $result = mysqli_query($link, "SELECT * FROM `apps` WHERE `secret` = '".$_SESSION['app']."'");

                        $row = mysqli_fetch_array($result);

						if($row["sellixsecret"] != NULL)

                        {

							

						if($row["sellixdayproduct"] != NULL)

                        {

							echo '<a data-sellix-product="'.$row["sellixdayproduct"].'" data-sellix-custom-Username="'.$_SESSION['username'].'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Purchase Day Keys (sellix)</a>';

						}

						if($row["sellixweekproduct"] != NULL)

                        {

							echo '<br><br><a data-sellix-product="'.$row["sellixweekproduct"].'" data-sellix-custom-Username="'.$_SESSION['username'].'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Purchase Week Keys (sellix)</a>';

						}

						if($row["sellixmonthproduct"] != NULL)

                        {

							echo '<br><br><a data-sellix-product="'.$row["sellixmonthproduct"].'" data-sellix-custom-Username="'.$_SESSION['username'].'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Purchase Month Keys (sellix)</a>';

						}

						if($row["sellixlifetimeproduct"] != NULL)

                        {

							echo '<br><br><a data-sellix-product="'.$row["sellixlifetimeproduct"].'" data-sellix-custom-Username="'.$_SESSION['username'].'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Purchase Lifetime Keys (sellix)</a>';

						}
                        }
						
						if($row["shoppysecret"] != NULL)

                        {

							

						if($row["shoppydayproduct"] != NULL)

                        {

							echo '<br><br><a data-shoppy-product="'.$row["shoppydayproduct"].'" data-shoppy-username="'.$_SESSION['username'].'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Purchase Day Keys (shoppy)</a>';

						}

						if($row["shoppyweekproduct"] != NULL)

                        {

							echo '<br><br><a data-shoppy-product="'.$row["shoppyweekproduct"].'" data-shoppy-username="'.$_SESSION['username'].'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Purchase Week Keys (shoppy)</a>';

						}

						if($row["shoppymonthproduct"] != NULL)

                        {

							echo '<br><br><a data-shoppy-product="'.$row["shoppymonthproduct"].'" data-shoppy-username="'.$_SESSION['username'].'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Purchase Month Keys (shoppy)</a>';

						}

						if($row["shoppylifetimeproduct"] != NULL)

                        {

							echo '<br><br><a data-shoppy-product="'.$row["shoppylifetimeproduct"].'" data-shoppy-username="'.$_SESSION['username'].'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Purchase Lifetime Keys (shoppy)</a>';

						}
                        }

						

                        if($row["resellerstore"] != NULL)

                        {

                        echo '<a href="'.$row["resellerstore"].'" target="resellerstore" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Purchase Keys</a>';

                        return;

                        }

                        ?>
						
						<?php

                            $result = mysqli_query($link, "SELECT `balance` FROM `accounts` WHERE `username` = '".$_SESSION['username']."'");

                            

                            $row = mysqli_fetch_array($result);

                            

                            $balance = $row["balance"];

                            

                            $balance = explode("|", $balance);

                            

                            $day = $balance[0];

                            $week = $balance[1];

                            $month = $balance[2];

                            $threemonth = $balance[3];

                            $sixmonth = $balance[4];

                            $life = $balance[5];

                            

                            echo '
                            
                            <p>'.$day.' Day Key(s)</p>
                            <br>
                            <p>'.$week.' Week Key(s)</p>
                            <br>
                            <p>'.$month.' Month Key(s)</p>
                            <br>
                            <p>'.$threemonth.' Three Month Key(s)</p>
                            <br>
                            <p>'.$sixmonth.' Six Month Key(s)</p>
                            <br>
                            <p>'.$life.' Lifetime Key(s)</p>
                            ';

                            

                            ?>
                            </div>
                        </div>
                    </div>
                </div>
	
</div>
<!--end::Container-->
