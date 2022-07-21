<?php
ob_start();
include '../includes/connection.php';
include '../includes/functions.php';

$_SESSION['role'] = $role;

    if ($role == "Reseller")
    {
        die('Resellers Not Allowed Here');
		
    }
if ($_SESSION['role'] != "seller")
{
    exit();
}

?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
<?php
($result = mysqli_query($link, "SELECT * FROM `apps` WHERE `secret` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {
        $sellerkey = $row['sellerkey'];
    }
}

?>

                        <div class="card">
                            <div class="card-body">
                                <form class="form" method="post">
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Seller Key</label>
                                        <div class="col-10">
                                            <label class="form-control"><p class="secret"><?php echo $sellerkey; ?></p></label>
                                        </div>
                                    </div>
                                    <br>
									<div class="form-group row">
                                        <label for="example-tel-input" class="col-2 col-form-label">Seller Link <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="You can use this link with Shoppy or Sellix dynamic product type to automatically send key to customer so you never have to restock."></i></label>
                                        <div class="col-10">
                                            <label class="form-control" style="height:auto;"><?php
echo '<a href="https://'.($_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST']).'/site/app/api/seller/?sellerkey=' . $sellerkey . '&type=add&expiry=1&mask=XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX&level=1&amount=1&format=text" target="_blank" class="secretlink">https://'.($_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST']).'/site/app/api/seller/?sellerkey=' . $sellerkey . '&type=add&expiry=1&mask=XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX&level=1&amount=1&format=text</a>';

?></label>
                                        </div>
                                    </div>
                                    <br>
                                    <a type="button" class="btn btn-info"target="popup" onclick="window.open('https://discord.com/api/oauth2/authorize?client_id=866538681308545054&amp;permissions=268443648&amp;scope=bot','popup','width=600,height=600'); return false;"> <i class="fab fa-discord"></i>  Add Discord Bot</a>  
                                </form>
                            </div>
                        </div>
                    </div>
                </div>	
</div>
<!--end::Container-->
