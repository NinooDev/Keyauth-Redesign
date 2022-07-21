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
            ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = 	'$username'")) or die(mysqli_error($link));
            $row = mysqli_fetch_array($result);
        
            $role = $row['role'];
            $_SESSION['role'] = $role;
			
            $keylevels = $row['keylevels'];

			
                            
?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
<form method="POST">
<button data-bs-toggle="modal" type="button" data-bs-target="#create-keys"
class="dt-button buttons-print btn btn-primary mr-1"><i
class="fas fa-plus-circle fa-sm text-white-50"></i> Create keys</button>
</form>
	

<div id="create-keys" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title">Add Licenses</h4>
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
                                    <div class="modal-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Amount:</label>
                                                <input type="number" class="form-control" name="amount"
                                                    placeholder="Default 1">
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Key Mask:</label>
                                                <input type="text" class="form-control"
                                                    value="XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX"
                                                    placeholder="Key Format. X is capital random char, x is lowercase"
                                                    name="mask" required>
                                            </div>

                                            <?php 
                                                    
                                                    if ($keylevels != "N/A"){

                                                        $keylevels = explode("|", $keylevels);
                                                        
                                                       

                                                        foreach ($keylevels as $levels) {
                                                           $options .= '<option>' . $levels . '</option>';
                                                        }                                                       

                                                        echo'
                                                            <div class="form-group">
                                                            <label for="recipient-name" class="control-label">Key Level:</label>
                                                            <select name="level" class="form-control">' . $options . '</select>
                                                            </div>
                                                        ';

                                                    } else{
                                                        echo'
                                                        <div class="form-group">
                                                        <label for="recipient-name" class="control-label">License Level:</label>
                                                        <input type="text" class="form-control" name="level" placeholder="Default 1">
                                                        </div>
                                                        ';
                                                    }
                                                    
                                                    
                                                    ?>


                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">License Note:</label>
                                                <input type="text" class="form-control" name="note"
                                                    placeholder="Optional, e.g. this license was for Joe">
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">License Expiry
                                                    Duration:</label>
                                                <select name="expiry" class="form-control">
                                                    <option>1 Day</option>
                                                    <option>1 Week</option>
                                                    <option>1 Month</option>
                                                    <option>3 Month</option>
                                                    <option>6 Month</option>
                                                    <option>Lifetime</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-danger"
                                            name="genkeys">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php
					
					
							function license_masking($mask)
			{
				$mask_arr = str_split($mask);
                $size_of_mask = count($mask_arr);
                for($i = 0; $i < $size_of_mask; $i++)
				{
                    if($mask_arr[$i] === 'X')
					{
                        $mask_arr[$i] = random_string_upper(1);
					}
					else if($mask_arr[$i] === 'x')
					{
                        $mask_arr[$i] = random_string_lower(1);
					}
				}
				return implode('', $mask_arr);
			}

			function license($amount,$mask,$expiry,$level,$link)
			{
				
			$licenses = array();
			
			for ($i = 0; $i < $amount; $i++) {
	
			$license = license_masking($mask);
			mysqli_query($link, "INSERT INTO `keys` (`key`, `note`, `expires`, `status`, `level`, `genby`, `gendate`, `app`) VALUES ('$license',NULLIF('$note', ''), '$expiry','Not Used','$level','" . $_SESSION['username'] . "', '" . time() . "', '" . $_SESSION['app'] . "')");
			// echo $key;
			$licenses[] = $license;
			}

			return $licenses;
			}
                                        
                            if(isset($_POST['genkeys']))
                            {
                                
                                $amount = sanitize($_POST['amount']);
                                if($amount > 100)
                                {
								mysqli_close($link);
								error("Generating Keys has been limited to 100 per time to reduce accidental spam. Please try again.");
								echo "<meta http-equiv='Refresh' Content='2;'>";
								return;
                                }
                                
                                $level = sanitize($_POST['level']);
                                $note = sanitize($_POST['note']);
                                
								
								if($keylevels != "N/A" && !in_array($level,$keylevels))
								{
								error("Not Authorized To Use That Level");
								echo "<meta http-equiv='Refresh' Content='2;'>";
								return;	
								}
								
                                if(!isset($amount) || trim($amount) == '')
                                {
                                $amount = 1;
                                }
                                
                                if(!isset($level) || trim($level) == '')
                                {
                                $level = 1;
                                }
                                $expiry = sanitize($_POST['expiry']);
                                
                                 if(!isset($expiry) || trim($expiry) == '')
                                {
								mysqli_close($link);
                                error("No Expiry Set!");
								echo "<meta http-equiv='Refresh' Content='2;'>";
								return;
                                }
                                else
                                {
								
								$expiry = sanitize($_POST['expiry']);
								
								$result = mysqli_query($link, "SELECT `balance` FROM `accounts` WHERE `username` = '".$_SESSION['username']."'");
                            
                                $row = mysqli_fetch_array($result);
                            
                                $balance = $row["balance"];
                            
                                $balance = explode("|", $balance);
                            
                                $day = $balance[0];
                                $week = $balance[1];
                                $month = $balance[2];
                                $threemonth = $balance[3];
                                $sixmonth = $balance[4];
                                $lifetime = $balance[5];
                                
                                if($expiry == "1 Day")
                                {
                                    $expiry = 86400;
                                    $day = $day - $amount;
                                }
                                else if($expiry == "1 Week")
                                {
                                    $expiry = 604800;
                                    $week = $week - $amount;
                                }
                                else if($expiry == "1 Month")
                                {
                                    $expiry = 2.592e+6;
                                    $month = $month - $amount;
                                }
                                else if($expiry == "3 Month")
                                {
                                    $expiry = 7.862e+6;
                                    $threemonth = $threemonth - $amount;
                                }
                                else if($expiry == "6 Month")
                                {
                                    $expiry = 1.572e+7;
                                    $sixmonth = $sixmonth - $amount;
                                }
                                else if($expiry == "Lifetime")
                                {
                                    $expiry = 8.6391e+8;
                                    $lifetime = $lifetime - $amount;
                                }
                                else
                                {
                            error("Invalid Expiry!");
                            echo "<meta http-equiv='Refresh' Content='2;'>";
                            return;    
                                }
								
								if($day < 0 || $month < 0 || $week < 0 || $threemonth < 0 || $sixmonth < 0 || $lifetime < 0)
                                {
                                    
                            error("Not Enough Balance!");
                            echo "<meta http-equiv='Refresh' Content='2;'>";
                            return;
                                }
                                
                                
                               $balance = $day . '|' . $week . '|' . $month . '|' . $threemonth . '|' . $sixmonth . '|' . $lifetime;
							   
                                $mask = sanitize($_POST['mask']);
								
								$result = mysqli_query($link, "SELECT * FROM `keys` WHERE `app` = '".$_SESSION['app']."' AND `key` = '$mask'");
                                if(mysqli_num_rows($result) !== 0)
								{
									mysqli_close($link);
									error("Key already exists, try a different one!");
									echo "<meta http-equiv='Refresh' Content='2'>";
									return;
								}
								
								
								// mask instead of format
								// check if amount is over one and mask does not contain any Xs
                                if($amount > 1 && strpos($mask, 'X') === false && strpos($mask, 'x') === false)
                                {
								mysqli_close($link);
                                error("Can\'t do custom key with amount greater than one");
                                echo "<meta http-equiv='Refresh' Content='4;'>";
								return;
                                }
								
								
                                $key = license($amount,$mask,$expiry,$level,$link);
								
                                if($result)
                                {
                                mysqli_query($link, "UPDATE `accounts` SET `balance` = '$balance' WHERE `username` = '".$_SESSION['username']."'");
								
								wh_log($logwebhook, "{$username} has created {$amount} keys", $webhookun);
								
                                
                                if($amount > 1)
                                {
                                echo "<meta http-equiv='Refresh' Content='0; url=pages/reseller-license-download.php'>";
								}
                                success("License Created And Copied To Clipboard!");

echo "<script>
navigator.clipboard.writeText('".array_values($key)[0]."');
</script>";
echo "<meta http-equiv='Refresh' Content='4;'>"; 
success("License Created And Copied To Clipboard!");

                                }
                                }
                                }
                            
							
							

                    ?>

                        <script type="text/javascript">
                        var myLink = document.getElementById('mylink');

                        myLink.onclick = function() {


                            $(document).ready(function() {
                                $("#content").fadeOut(100);
                                $("#changeapp").fadeIn(1900);
                            });

                        }
                        </script>
                        <div id="ban-key" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title">Ban License</h4>
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
                                    <div class="modal-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Ban reason:</label>
                                                <input type="text" class="form-control" name="reason"
                                                    placeholder="Reason for ban" required>
                                                <input type="hidden" class="bankey" name="key">
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-danger"
                                            name="bankey">Ban</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="kt_datatable_blacklists" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
            <th>Key</th>
            <th>Generated By</th>
            <th>Duration</th>
            <th>Note</th>
            <th>Used By</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    
    <tbody>
                                            <?php
		if($_SESSION['app']) {
        ($result = mysqli_query($link, "SELECT * FROM `keys` WHERE `genby` = '".$_SESSION['username']."'")) or die(mysqli_error($link));
        
		$rows = array();
        while ($r = mysqli_fetch_assoc($result))
        {
            $rows[] = $r;
        }

        foreach ($rows as $row)
        {

        $key = $row['key'];
		$badge = $row['status'] == "Not Used" ? 'badge badge-success' : 'badge badge-danger';
				?>
                                                    <tr>

                                                    <td><?php echo $key; ?></td>

                                                    <td><?php echo $row["genby"]; ?></td>
                                                    
                                                    <td><?php echo $row["expires"] / 86400 ?> Day(s)</td>
                                                    <td><?php echo $row["note"] ?? "N/A"; ?></td>
													<td><?php echo $row["usedby"]; ?></td>
                                                    <td><label class="<?php echo $badge; ?>"><?php echo $row['status']; ?></label></td>

                                            <form method="POST"><td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" name="deletekey" value="<?php echo $key; ?>">Delete</button>
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ban-key" onclick="bankey('<?php echo $key; ?>')">Ban</a>
                                                <button class="dropdown-item" name="unbankey" value="<?php echo $key; ?>">Unban</button>
                                                <div class="dropdown-divider"></div>
												<?php
                                                }

                                            }

                                        ?>
                                        </tbody>


</table>
                  
</div>
<script>
    function bankey(key) {
        var bankey = $('.bankey');
        bankey.attr('value', key);
    }
    </script>
<!--end::Container-->
