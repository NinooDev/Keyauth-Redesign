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
	
<form method="POST">
<button data-bs-toggle="modal" type="button" data-bs-target="#deleteusers" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete All Users</button>  
<button data-bs-toggle="modal" type="button" data-bs-target="#resetall" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-redo-alt fa-sm text-white-50"></i> HWID Reset All Users</button>
</form>
<br>

<div id="ban-user" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Ban User</h4>
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
                                                        <input type="text" class="form-control" name="reason" placeholder="Reason for ban" required>
														<input type="hidden" class="banuser" name="un">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="banuser">Ban</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>
<div class="modal fade" tabindex="-1" id="deleteusers">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete All Users</h2>

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
                <label class="fs-5 fw-bold mb-2">
                <p> Are you sure you want to delete all users? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="delusers" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="resetall">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Reset All Users</h2>

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
                <label class="fs-5 fw-bold mb-2">
                <p> Are you sure you want to reset HWID for all users? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="resetall" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<table id="kt_datatable_blacklists" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Username</th>
        <th>HWID</th>
        <th>IP</th>
        <th>Action</th>
        </tr>
    </thead>

    
    <tbody>
<?php
		if($_SESSION['app']) {
        ($result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '".$_SESSION['app']."' AND `owner` = '".$_SESSION['username']."'")) or die(mysqli_error($link));
        $rows = array();
        while ($r = mysqli_fetch_assoc($result))
        {
            $rows[] = $r;
        }

        foreach ($rows as $row)
        {

        $user = $row['username'];
		?>

                                                    <tr>

                                                    <td><?php echo $row["username"]; ?></td>

                                                    <td><?php echo $row["hwid"] ?? "N/A"; ?></td>
													
                                                    <td><?php echo $row["ip"] ?? "N/A"; ?></td>

                                                    <td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu">
                                                <form method="post"><button class="dropdown-item" name="deleteuser" value="<?php echo $user; ?>">Delete</button>
												<button class="dropdown-item" name="resetuser" value="<?php echo $user; ?>">Reset HWID</button>
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ban-user" onclick="banuser('<?php echo $user; ?>')">Ban</a>
                                                <button class="dropdown-item" name="unbanuser" value="<?php echo $user; ?>">Unban</button>
                                                <div class="dropdown-divider"></div>
												<button class="dropdown-item" name="edituser" value="<?php echo $user; ?>">Edit</button></div></td></tr></form>
<?php
                                                

                                            }
                                            
		}

                                        ?>
                                        </tbody>


</table>

<?php
				if(isset($_POST['deleteuser']))
				{
					$username = sanitize($_POST['deleteuser']);
					mysqli_query($link, "DELETE FROM `users` WHERE `app` = '".$_SESSION['app']."' AND `username` = '$username' AND `owner` = '".$_SESSION['username']."'");
					if(mysqli_affected_rows($link) != 0)
					{
						mysqli_query($link, "DELETE FROM `subs` WHERE `app` = '".$_SESSION['app']."' AND `user` = '$username'");
						success("User Successfully Deleted!");
						echo "<meta http-equiv='Refresh' Content='2'>";
					}
					else
					{
						mysqli_close($link);
						error("Failed To Delete User!");
					}
				}
				if(isset($_POST['resetuser']))
				{
					$un = sanitize($_POST['resetuser']);
					mysqli_query($link, "UPDATE `users` SET `hwid` = '' WHERE `app` = '".$_SESSION['app']."' AND `username` = '$un' AND `owner` = '".$_SESSION['username']."'");
					if(mysqli_affected_rows($link) != 0)
					{
						success("User Successfully Reset");
						echo "<meta http-equiv='Refresh' Content='2'>";
					}
					else
					{
						mysqli_close($link);
						error("Failed To Reset User");
					}
				}
				if(isset($_POST['banuser']))
				{
					$un = sanitize($_POST['un']);
					
					$result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '".$_SESSION['app']."' AND `username` = '$un' AND `owner` = '".$_SESSION['username']."'");
					if(mysqli_num_rows($result) == 0)
					{
						mysqli_close($link);
						error("User not Found!");
						echo "<meta http-equiv='Refresh' Content='2'>";
						return;
					}
					
					$row = mysqli_fetch_array($result);
					$hwid = $row["hwid"];
					$ip = $row["ip"];
					$reason = sanitize($_POST['reason']);
					
					mysqli_query($link, "UPDATE `users` SET `banned` = '$reason' WHERE `app` = '".$_SESSION['app']."' AND `username` = '$un' AND `owner` = '".$_SESSION['username']."'");
					
					if(mysqli_affected_rows($link) != 0)
					{
						if($hwid != NULL)
						{
						mysqli_query($link, "INSERT INTO `bans`(`hwid`,`type`, `app`) VALUES ('$hwid','hwid','".$_SESSION['app']."')");
						}
						if($ip != NULL)
						{
						mysqli_query($link, "INSERT INTO `bans`(`ip`,`type`, `app`) VALUES ('$ip','ip','".$_SESSION['app']."')");
						}
						success("User Successfully Banned!");
						echo "<meta http-equiv='Refresh' Content='2'>";
					}
					else
					{
						mysqli_close($link);
						error("Failed To Ban User");
					}
				}
				
				if(isset($_POST['unbanuser']))
				{
					$un = sanitize($_POST['unbanuser']);
					
					$result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '".$_SESSION['app']."' AND `username` = '$un' AND `owner` = '".$_SESSION['username']."'");
					if(mysqli_num_rows($result) == 0)
					{
						mysqli_close($link);
						error("User not Found!");
						echo "<meta http-equiv='Refresh' Content='2'>";
						return;
					}
					
					$row = mysqli_fetch_array($result);
					$hwid = $row["hwid"];
					$ip = $row["ip"];
					
					mysqli_query($link, "UPDATE `users` SET `banned` = NULL WHERE `app` = '".$_SESSION['app']."' AND `username` = '$un' AND `owner` = '".$_SESSION['username']."'");
					
					if(mysqli_affected_rows($link) != 0)
					{
						mysqli_query($link, "DELETE FROM `bans` WHERE `hwid` = '$hwid' OR `ip` = '$ip' AND `app` = '".$_SESSION['app']."'");
						success("User Successfully Unbanned!");
						echo "<meta http-equiv='Refresh' Content='2'>";
					}
					else
					{
						mysqli_close($link);
						error("Failed To Unban User");
					}
				}
				
				if(isset($_POST['edituser']))
				{
					$un = sanitize($_POST['edituser']);
					
					$result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$un' AND `app` = '".$_SESSION['app']."' AND `owner` = '".$_SESSION['username']."'");
                    if(mysqli_num_rows($result) == 0)
					{
						mysqli_close($link);
						error("User not Found!");
						echo "<meta http-equiv='Refresh' Content='2'>";
						return;
					}
					
                    $row = mysqli_fetch_array($result);
					?>
					<div id="edit-user" class="modal show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true"o ydo >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Edit User</h4>
                                                <!--begin::Close-->
                                                <div class="btn btn-sm btn-icon btn-active-color-primary" onClick="window.location.href=window.location.href">
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
                                                        <label for="recipient-name" class="control-label">Password:</label>
                                                        <input type="password" class="form-control" name="pass" placeholder="Set new password, we cannot read old password because it's hashed with BCrypt">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Active Subscriptions:</label>
                                                        <select class="form-control" name="sub">
														<?php
														$result = mysqli_query($link, "SELECT * FROM `subs` WHERE `user` = '$un' AND `app` = '".$_SESSION['app']."' AND `expiry` > '".time()."'");
														
														$rows = array();
														while ($r = mysqli_fetch_assoc($result))
														{
															$rows[] = $r;
														}
														
														foreach ($rows as $subrow)
														{
                                                        if(!$subrow["expiry"] == NULL) { $time = date('Y/m/d H:i', $subrow["expiry"]); } else { echo "N/A"; }
														$value = "[" . $subrow['subscription'] . "] - Expires: $time";
                                                       

														?>
														<option><?php echo $value; ?></option>
														<?php
														}
														?>
														</select>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Additional HWID:</label>
                                                        <input type="text" class="form-control" name="hwid" placeholder="Enter HWID if you want this key to support multiple computers">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">HWID:</label>
                                                        <p><?php echo $row['hwid']; ?></p>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">IP:</label>
                                                        <p><?php echo $row['ip']; ?></p>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onClick="window.location.href=window.location.href" class="btn btn-secondary">Close</button>
                                                <button class="btn btn-warning" value="<?php echo $un; ?>" name="deletesub">Delete Subscription</button>
                                                <button class="btn btn-danger" value="<?php echo $un; ?>" name="saveuser">Save</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>
									<?php
				}
				
				if(isset($_POST['saveuser']))
				{
					$un = sanitize($_POST['saveuser']);
					
					$hwid = sanitize($_POST['hwid']);
					
					$pass = sanitize($_POST['pass']);
					
					if(isset($hwid) && trim($hwid) != '')
					{
						$result = mysqli_query($link, "SELECT `hwid` FROM `users` WHERE `username` = '$un' AND `app` = '".$_SESSION['app']."' AND `owner` = '".$_SESSION['username']."'");                           
						$row = mysqli_fetch_array($result);                      
						$hwidd = $row["hwid"];

						$hwidd = $hwidd .= $hwid;

						mysqli_query($link, "UPDATE `users` SET `hwid` = '$hwidd' WHERE `username` = '$un' AND `app` = '".$_SESSION['app']."' AND `owner` = '".$_SESSION['username']."'");
					}
					
					if(isset($pass) && trim($pass) != '')
					{
						mysqli_query($link, "UPDATE `users` SET `password` = '".password_hash($pass, PASSWORD_BCRYPT)."' WHERE `username` = '$un' AND `app` = '".$_SESSION['app']."' AND `owner` = '".$_SESSION['username']."'");
					}
		
					success("Successfully Updated User");
					echo "<meta http-equiv='Refresh' Content='2'>";
				}
				
				if(isset($_POST['deletesub']))
				{
					$un = sanitize($_POST['deletesub']);
					
					$result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$un' AND `app` = '".$_SESSION['app']."' AND `owner` = '".$_SESSION['username']."'");
                    if(mysqli_num_rows($result) == 0)
					{
						mysqli_close($link);
						error("User not Found!");
						echo "<meta http-equiv='Refresh' Content='2'>";
						return;
					}
					
					$sub = sanitize($_POST['sub']);
					
					function get_string_between($string, $start, $end){
						$string = ' ' . $string;
						$ini = strpos($string, $start);
						if ($ini == 0) return '';
						$ini += strlen($start);
						$len = strpos($string, $end, $ini) - $ini;
						return substr($string, $ini, $len);
					}
					
					$sub = get_string_between($sub, '[', ']');
					
					mysqli_query($link, "DELETE FROM `subs` WHERE `app` = '".$_SESSION['app']."' AND `user` = '$un' AND `subscription` = '$sub'");
					if(mysqli_affected_rows($link) != 0)
					{
					success("Successfully Deleted User\'s Subscription");
					echo "<meta http-equiv='Refresh' Content='2'>";
					}
					else
					{
						mysqli_close($link);
						error("Failed To Delete User\'s Subscription!");
					}
					
				}
				
				if(isset($_POST['delusers']))
				{
					mysqli_query($link, "DELETE FROM `users` WHERE `app` = '".$_SESSION['app']."' AND `owner` = '".$_SESSION['username']."'");
					if(mysqli_affected_rows($link) != 0)
					{
						success("Users Successfully Deleted!");
						echo "<meta http-equiv='Refresh' Content='2'>";
					}
					else
					{
						mysqli_close($link);
						error("Failed To Delete Users!");
					}
				}
				
				if(isset($_POST['resetall']))
				{
					mysqli_query($link, "UPDATE `users` SET `hwid` = '' WHERE `app` = '".$_SESSION['app']."' AND `owner` = '".$_SESSION['username']."'");
					if(mysqli_affected_rows($link) != 0)
					{
						success("Users Successfully Reset!");
						echo "<meta http-equiv='Refresh' Content='2'>";
					}
					else
					{
						mysqli_close($link);
						error("Failed To Reset Users!");
					}
				}
					?>

</div>
<script>
                        
		function banuser(username) {
		 var banuser = $('.banuser');
		 banuser.attr('value', username);
      }
                    </script>
<!--end::Container-->
