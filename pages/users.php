<?php

include '../includes/connection.php';
include '../includes/functions.php';




if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']))
{
    header("Location: ../auth/login.php");
    exit();
}

$_SESSION['role'] = $role;

    if ($role == "Reseller")
    {
        die('Resellers Not Allowed Here');
		
    }
?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">

<form method="POST">
    <button data-bs-toggle="modal" type="button" id="modal" data-bs-target="#create-user" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create User</button>  
    <button data-bs-toggle="modal" type="button" id="modal" data-bs-target="#set-user-var" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Set Variable</button>  
    <button data-bs-toggle="modal" type="button" data-bs-target="#import-users" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-cloud-upload-alt fa-sm text-white-50"></i> Import users</button><br><br>  
    <button data-bs-toggle="modal" type="button" data-bs-target="#extend-user" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-clock fa-sm text-white-50"></i> Extend User(s)</button>  
    <button type="button" data-bs-toggle="modal" data-bs-target="#delete-allusers" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete All Users</button> 
    <button type="button" data-bs-toggle="modal" data-bs-target="#delete-allexpired" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete Expired Users</button>  
    <button type="button" data-bs-toggle="modal" data-bs-target="#reset-allusers" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-redo-alt fa-sm text-white-50"></i> HWID Reset All Users</button>
</form>

<div id="create-user" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Add User</h4>

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

                                                        <label for="recipient-name" class="control-label">Username:</label>

                                                        <input type="text" class="form-control" name="username" placeholder="Username for user" required>

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Password:</label>

                                                        <input type="password" class="form-control" name="password" placeholder="leave blank if you want it to set to first password used to login">

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Subscription: </label>

                                                        <select name="sub" class="form-control">

														<?php
($result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `app` = '" . $_SESSION['app'] . "' ORDER BY CHAR_LENGTH(`name`) DESC")) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {
        echo "  <option>" . $row["name"] . "</option>";
    }
}
?>

														</select>

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Subscription Expiry:</label>

                                                        <?php
echo '<input class="form-control" type="datetime-local" name="expiry" value="' . date("Y-m-d\TH:i", time()) . '" required>';
?>

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button class="btn btn-danger" name="adduser">Add</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>

									<div id="set-user-var" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Set Variable</h4>

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

                                                        <label for="recipient-name" class="control-label">User:</label>

                                                        <select name="user" class="form-control"><option value="all">All</option>

														<?php
($result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '" . $_SESSION['app'] . "' ORDER BY CHAR_LENGTH(`username`) DESC")) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {
        echo "<option value=\"" . $row["username"] . "\">" . $row["username"] . "</option>";
    }
}
?>

														</select>

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Variable:</label>

														<input type="text" class="form-control" name="var" placeholder="Variable name (enter one if creating new one)" list="vars" required>

                                                        <datalist id="vars">

														<?php
($result = mysqli_query($link, "SELECT * FROM `uservars` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {
        echo "  <option>" . $row["name"] . "</option>";
    }
}
?>

														</datalist>

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Variable Data: <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="Assigns variable to selected user(s) which you can get and set from loader"></i></label>

                                                        <input type="text" class="form-control" name="data" placeholder="User variable data" required>

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button class="btn btn-danger" name="setvar">Add</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>

                                    <div id="import-users" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Import Users</h4>

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

                                                        <label for="recipient-name" class="control-label">Users: <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="No password is imported since passwords could be hashed in different formats or inaccessible to you when trying to export your users from another service. KeyAuth will use the password the user first signs in with."></i></label>

                                                        <input class="form-control" name="users" placeholder="Format: username,hwid,days|username,hwid,days">

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button class="btn btn-danger waves-effect waves-light" name="importusers">Add</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>

									<div id="extend-user" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Extend User(s)</h4>

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

                                                        <label for="recipient-name" class="control-label">User:</label>

                                                        <select name="user" class="form-control"><option value="all">All</option>

														<?php
($result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '" . $_SESSION['app'] . "' ORDER BY CHAR_LENGTH(`username`) DESC")) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {
        echo "<option value=\"" . $row["username"] . "\">" . $row["username"] . "</option>";
    }
}
?>

														</select>

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Subscription:</label>

                                                        <select name="sub" class="form-control">

														<?php
($result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `app` = '" . $_SESSION['app'] . "' ORDER BY CHAR_LENGTH(`name`) DESC")) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {
        echo "  <option>" . $row["name"] . "</option>";
    }
}
?>

														</select>

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Subscription Expiry:</label>

                                                        <?php
echo '<input class="form-control" type="datetime-local" name="expiry" value="' . date("Y-m-d\TH:i", time()) . '" required>';
?>

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button class="btn btn-danger waves-effect waves-light" name="extenduser">Add</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>

										<div id="rename-app" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Rename Application</h4>

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

                                                        <label for="recipient-name" class="control-label">Name:</label>

                                                        <input type="text" class="form-control" name="name" placeholder="New Application Name">

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button class="btn btn-danger waves-effect waves-light" name="renameapp">Add</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>

                                    <div id="ban-user" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

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

<!--begin::Modal - Delete all users-->
<div class="modal fade" tabindex="-1" id="delete-allusers">
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
<!--end::Modal - Delete all users-->
<!--begin::Modal - Delete all expired users-->
<div class="modal fade" tabindex="-1" id="delete-allexpired">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete All Expired Users</h2>

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
                <p> Are you sure you want to delete all expired users? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="delexpusers" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Delete all expired users-->

<!--begin::Modal - HWID reset all users-->
<div class="modal fade" tabindex="-1" id="reset-allusers">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">HWID Reset All Users</h2>

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
                <p> Are you sure you want to hwid reset all users? </p>
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
<!--end::Modal - HWID reset all users-->

    <table id="kt_datatable_users" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Username</th>
        <th>HWID</th>
        <th>IP</th>
        <th>Creation Date</th>
        <th>Last Login Date</th>
        <th>Banned</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>




<?php
if ($_SESSION['app'])
{
($result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
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

                

                <td><?php if(!$row["createdate"] == NULL) { echo date('Y/m/d @ H:i', $row["createdate"]); } else { echo "N/A"; } ?></td>

                

                <td><?php if(!$row["lastlogin"] == NULL) { echo date('Y/m/d @ H:i', $row["lastlogin"]); } else { echo "N/A"; } ?></td>

                

                <td><?php echo $row["banned"] ?? "N/A"; ?></td>



                <form method="POST"><td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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










function deleteSingular($username)
{
	global $link;
	$username = sanitize($username);
	
    mysqli_query($link, "DELETE FROM `subs` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `user` = '$username'");
    mysqli_query($link, "DELETE FROM `users` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `username` = '$username'");
	
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function resetSingular($username)
{
	global $link;
	$username = sanitize($username);
	
    mysqli_query($link, "UPDATE `users` SET `hwid` = NULL WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `username` = '$username'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function setVariable($user, $var, $data)
{
	global $link;
	$user = sanitize($user);
	$var = sanitize($var);
	$data = sanitize($data);
	
	if ($user == "all")
    {
        $result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
        if (mysqli_num_rows($result) == 0)
        {
            return 'missing';
        }
        $rows = array();
        while ($r = mysqli_fetch_assoc($result))
        {
            $rows[] = $r;
        }
        foreach ($rows as $row)
        {
            mysqli_query($link, "REPLACE INTO `uservars` (`name`, `data`, `user`, `app`) VALUES ('$var', '$data', '" . $row['username'] . "', '" . ($secret ?? $_SESSION['app']) . "')");
        }
    }
    else
    {
        mysqli_query($link, "REPLACE INTO `uservars` (`name`, `data`, `user`, `app`) VALUES ('$var', '$data', '$user', '" . ($secret ?? $_SESSION['app']) . "')");
    }
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function ban($username, $reason)
{
	global $link;
	$username = sanitize($username);
	$reason = sanitize($reason);
	
	$result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `username` = '$username'");
    if (mysqli_num_rows($result) == 0)
    {
        return 'missing';
    }
    $row = mysqli_fetch_array($result);
    $hwid = $row["hwid"];
    $ip = $row["ip"];
    mysqli_query($link, "UPDATE `users` SET `banned` = '$reason' WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `username` = '$username'");
    if ($hwid != NULL)
    {
        mysqli_query($link, "INSERT INTO `bans`(`hwid`,`type`, `app`) VALUES ('$hwid','hwid','" . ($secret ?? $_SESSION['app']) . "')");
    }
    if ($ip != NULL)
    {
        mysqli_query($link, "INSERT INTO `bans`(`ip`,`type`, `app`) VALUES ('$ip','ip','" . ($secret ?? $_SESSION['app']) . "')");
    }
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function unban($username)
{
	global $link;
	$username = sanitize($username);
	
    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `username` = '$username'");
    if (mysqli_num_rows($result) == 0)
    {
        return 'missing';
    }
    $row = mysqli_fetch_array($result);
    $hwid = $row["hwid"];
    $ip = $row["ip"];
	mysqli_query($link, "DELETE FROM `bans` WHERE `hwid` = '$hwid' OR `ip` = '$ip' AND `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    mysqli_query($link, "UPDATE `users` SET `banned` = NULL WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `username` = '$username'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function deleteVar($username, $var)
{
	global $link;
	$username = sanitize($username);
	$var = sanitize($var);
	
    mysqli_query($link, "DELETE FROM `uservars` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `user` = '$username' AND `name` = '$var'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function deleteSub($username, $sub)
{
	global $link;
	$username = sanitize($username);
	$sub = sanitize($sub);
	
    mysqli_query($link, "DELETE FROM `subs` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `user` = '$username' AND `subscription` = '$sub'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function extend($username, $sub, $expiry)
{
	global $link;
	$username = sanitize($username);
	$sub = sanitize($sub);
	$expiry = sanitize($expiry);
	
    $result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `name` = '$sub' AND `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_num_rows($result) == 0)
    {
        return 'sub_missing';
    }
    else if ($expiry < time())
    {
        return 'date_past';
    }
    if ($username == "all")
    {
        $result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
        if (mysqli_num_rows($result) == 0)
        {
            return 'missing';
        }
        $rows = array();
        while ($r = mysqli_fetch_assoc($result))
        {
            $rows[] = $r;
        }
        foreach ($rows as $row)
        {
            mysqli_query($link, "INSERT INTO `subs` (`user`, `subscription`, `expiry`, `app`) VALUES ('" . $row['username'] . "','$sub', '$expiry', '" . ($secret ?? $_SESSION['app']) . "')");
        }
    }
    else
    {
        $result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$username' AND `app` = '" . ($secret ?? $_SESSION['app']) . "'");
        if (mysqli_num_rows($result) == 0)
        {
            return 'missing';
        }
        mysqli_query($link, "INSERT INTO `subs` (`user`, `subscription`, `expiry`, `app`) VALUES ('$username','$sub', '$expiry', '" . ($secret ?? $_SESSION['app']) . "')");
    }
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function add($username, $sub, $expiry, $password = null)
{
	global $link;
	$username = sanitize($username);
	if(!empty($password))
	$password = password_hash(sanitize($password) , PASSWORD_BCRYPT);
	$sub = sanitize($sub);
	$expiry = sanitize($expiry);
	
    $result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `name` = '$sub' AND `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_num_rows($result) == 0)
    {
        return 'sub_missing';
    }
    else if ($expiry < time())
    {
        return 'date_past';
    }
	
	mysqli_query($link, "INSERT INTO `subs` (`user`, `subscription`, `expiry`, `app`) VALUES ('$username','$sub', '$expiry', '" . ($secret ?? $_SESSION['app']) . "')");
    mysqli_query($link, "INSERT INTO `users` (`username`, `password`, `hwid`, `app`,`owner`,`createdate`) VALUES ('$username',NULLIF('$password', ''), NULL, '" . ($secret ?? $_SESSION['app']) . "','" . ($_SESSION['username'] ?? 'SellerAPI') . "','" . time() . "')");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function deleteExpiredUsers($secret = null)
{
	global $link;

    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_num_rows($result) == 0)
    {
        return 'missing';
    }
    $rows = array();
    while ($r = mysqli_fetch_assoc($result))
    {
        $rows[] = $r;
    }
    $success = 0;
    foreach ($rows as $row)
    {
        $result = mysqli_query($link, "SELECT * FROM `subs` WHERE `user` = '" . $row['username'] . "' AND `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `expiry` > '" . time() . "'");
        if (mysqli_num_rows($result) == 0)
        {
            $success = 1;
            mysqli_query($link, "DELETE FROM `users` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `username` = '" . $row['username'] . "'");
        }
    }
    if ($success)
    {
        return 'success';
    }
    else
    {
        return 'failure';
    }
}
function deleteAll($secret = null)
{
	global $link;

    mysqli_query($link, "DELETE FROM `users` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function resetAll($secret = null)
{
	global $link;

    mysqli_query($link, "UPDATE `users` SET `hwid` = NULL WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}


if (isset($_POST['deleteuser']))
{
$resp = deleteSingular($_POST['deleteuser']);
switch ($resp)
{
case 'failure':
error("Failed to delete user!");
break;
case 'success':
success("Successfully deleted user!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['resetuser']))
{
$resp = resetSingular($_POST['resetuser']);
switch ($resp)
{
case 'failure':
error("Failed to reset user!");
break;
case 'success':
success("Successfully reset user!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['setvar']))
{
$resp = setVariable($_POST['user'], $_POST['var'], $_POST['data']);
switch ($resp)
{
case 'missing':
error("No users found!");
break;
case 'failure':
error("Failed to set variable!");
break;
case 'success':
success("Successfully set variable!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['banuser']))
{
$resp = ban($_POST['un'], $_POST['reason']);
switch ($resp)
{
case 'missing':
error("User not found!");
break;
case 'failure':
error("Failed to ban user!");
break;
case 'success':
success("Successfully banned user!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['unbanuser']))
{
$resp = unban($_POST['unbanuser']);
switch ($resp)
{
case 'missing':
error("User not found!");
break;
case 'failure':
error("Failed to unban user!");
break;
case 'success':
success("Successfully unbanned user!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['edituser']))
{
$un = sanitize($_POST['edituser']);
$result = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$un' AND `app` = '" . $_SESSION['app'] . "'");
if (mysqli_num_rows($result) == 0)
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

                    <label for="recipient-name" class="control-label">Username:</label>

                    <input class="form-control" name="username" placeholder="Set new username">

                </div>

                <div class="form-group">

                    <label for="recipient-name" class="control-label">Password:</label>

                    <input type="password" class="form-control" name="pass" placeholder="Set new password, we cannot read old password because it's hashed with BCrypt">

                </div>

                <div class="form-group">

                    <label for="recipient-name" class="control-label">Active Subscriptions: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="List of non-expired, non-paused subscriptions. Change selection if you want to delete one of them."></i></label>

                    <select class="form-control" name="sub">

                    <?php
$result = mysqli_query($link, "SELECT * FROM `subs` WHERE `user` = '$un' AND `app` = '" . $_SESSION['app'] . "' AND `expiry` > '" . time() . "'");
$rows = array();
while ($r = mysqli_fetch_assoc($result))
{
$rows[] = $r;
}
foreach ($rows as $subrow)
{
if(!$subrow["expiry"] == NULL) { $expiry = date('Y/m/d @ H:i', $subrow["expiry"]); } else { $expiry = "N/A"; }
$value = "[" . $subrow['subscription'] . "]" . " - Expires: " . $expiry ;
?>

                    <option><?php echo $value; ?></option>

                    <?php
}
?>

                    </select>

                </div>

                <div class="form-group">

                    <label for="recipient-name" class="control-label">User Variables: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="List of variables assigned to this user. Change selection if you want to delete one of them."></i></label>

                    <select class="form-control" name="var">

                    <?php
$result = mysqli_query($link, "SELECT * FROM `uservars` WHERE `user` = '$un' AND `app` = '" . $_SESSION['app'] . "'");
$rows = array();
while ($r = mysqli_fetch_assoc($result))
{
$rows[] = $r;
}
foreach ($rows as $varrow)
{
$value = $varrow['name'] . " : " . $varrow["data"];
?>

                    <option value="<?php echo $varrow['name']; ?>"><?php echo $value; ?></option>

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

                    <p><?php echo $row['hwid'] ?? "N/A"; ?></p>

                </div>

                <div class="form-group">

                    <label for="recipient-name" class="control-label">IP:</label>

                    <p><?php echo $row['ip'] ?? "N/A"; ?></p>

                </div>

        </div>

        <div class="modal-footer">

            <button type="button" onClick="window.location.href=window.location.href" class="btn btn-secondary" data-dismiss="modal">Close</button>

            <button class="btn btn-warning waves-effect waves-light" value="<?php echo $un; ?>" name="deletesub">Delete Subscription</button>

            <button class="btn btn-primary waves-effect waves-light" value="<?php echo $un; ?>" name="deletevar">Delete Variable</button>

            <button class="btn btn-danger waves-effect waves-light" value="<?php echo $un; ?>" name="saveuser">Save</button>

            </form>

        </div>

    </div>

</div>

</div>

<?php
}
if (isset($_POST['saveuser']))
{
$un = sanitize($_POST['saveuser']);
$username = sanitize($_POST['username']);
$hwid = sanitize($_POST['hwid']);
$pass = sanitize($_POST['pass']);
if (isset($hwid) && trim($hwid) != '')
{
$result = mysqli_query($link, "SELECT `hwid` FROM `users` WHERE `username` = '$un' AND `app` = '" . $_SESSION['app'] . "'");
$row = mysqli_fetch_array($result);
$hwidd = $row["hwid"];
$hwidd = $hwidd .= $hwid;
mysqli_query($link, "UPDATE `users` SET `hwid` = '$hwidd' WHERE `username` = '$un' AND `app` = '" . $_SESSION['app'] . "'");
}
if (isset($username) && trim($username) != '')
{
mysqli_query($link, "UPDATE `users` SET `username` = '$username' WHERE `username` = '$un' AND `app` = '" . $_SESSION['app'] . "'");
mysqli_query($link, "UPDATE `subs` SET `user` = '$username' WHERE `user` = '$un' AND `app` = '" . $_SESSION['app'] . "'");
}
if (isset($pass) && trim($pass) != '')
{
mysqli_query($link, "UPDATE `users` SET `password` = '" . password_hash($pass, PASSWORD_BCRYPT) . "' WHERE `username` = '$un' AND `app` = '" . $_SESSION['app'] . "'");
}
success("Successfully Updated User");
echo "<meta http-equiv='Refresh' Content='2'>";
}
if (isset($_POST['deletevar']))
{
$resp = deleteVar($_POST['deletevar'], $_POST['var']);
switch ($resp)
{
case 'failure':
error("Failed to delete variable!");
break;
case 'success':
success("Successfully deleted variable!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['deletesub']))
{
$sub = sanitize($_POST['sub']);
function get_string_between($string, $start, $end)
{
$string = ' ' . $string;
$ini = strpos($string, $start);
if ($ini == 0) return '';
$ini += strlen($start);
$len = strpos($string, $end, $ini) - $ini;
return substr($string, $ini, $len);
}
$sub = get_string_between($sub, '[', ']');

$resp = deleteSub($_POST['deletesub'], $sub);
switch ($resp)
{
case 'failure':
error("Failed to delete subscription!");
break;
case 'success':
success("Successfully deleted subscription!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['importusers']))
{
$users = sanitize($_POST['users']);
$text = explode("|", $users);
str_replace('"', "", $text);
str_replace("'", "", $text);
foreach ($text as $line)
{
$array = explode(',', $line);
$first = $array[0];
if (!isset($first) || $first == '')
{
error("Invalid Format!");
echo "<meta http-equiv='Refresh' Content='2;'>";
return;
}
$second = $array[1];
if (!isset($second) || $second == '')
{
error("Invalid Format!");
echo "<meta http-equiv='Refresh' Content='2;'>";
return;
}
$third = $array[2];
if (!isset($third) || $third == '')
{
error("Invalid Format!");
echo "<meta http-equiv='Refresh' Content='2;'>";
return;
}
$expiry = time() + $third * 86400;
mysqli_query($link, "INSERT INTO `users` (`username`, `hwid`, `app`,`owner`, `createdate`) VALUES ('$first','$second','" . $_SESSION['app'] . "','" . $_SESSION['username'] . "','" . time() . "')");
mysqli_query($link, "INSERT INTO `subs` (`user`, `subscription`, `expiry`, `app`) VALUES ('$first','default','$expiry','" . $_SESSION['app'] . "')");
}
success("Successfully imported users!");
echo "<meta http-equiv='Refresh' Content='3'>";
}
if (isset($_POST['extenduser']))
{	
$resp = extend($_POST['user'], $_POST['sub'], strtotime($_POST['expiry']));
switch ($resp)
{
case 'missing':
error("User(s) not found!");
break;
case 'sub_missing':
error("Subscription not found!");
break;
case 'date_past':
error("Subscription expiry must be set in the future!");
break;
case 'failure':
error("Failed to extend user(s)!");
break;
case 'success':
success("Successfully extended user(s)!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['adduser']))
{
$resp = add($_POST['username'], $_POST['sub'], strtotime($_POST['expiry']), NULL, $_POST['password']);
switch ($resp)
{
case 'sub_missing':
error("Subscription not found!");
break;
case 'date_past':
error("Subscription expiry must be set in the future!");
break;
case 'failure':
error("Failed to create user!");
break;
case 'success':
success("Successfully created user!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['delexpusers']))
{
$resp = deleteExpiredUsers();
switch ($resp)
{
case 'missing':
error("You have no users!");
break;
case 'failure':
error("No users are expired!");
break;
case 'success':
success("Successfully deleted expired users!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['delusers']))
{
$resp = deleteAll();
switch ($resp)
{
case 'failure':
error("Failed to delete all users!");
break;
case 'success':
success("Successfully deleted all users!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
if (isset($_POST['resetall']))
{
$resp = resetAll();
switch ($resp)
{
case 'failure':
error("Failed to reset all users!");
break;
case 'success':
success("Successfully reset all users!");
echo "<meta http-equiv='Refresh' Content='2'>";
break;
default:
error("Unhandled Error! Contact us if you need help");
break;
}
}
?>
<script>

                        

function banuser(username) {

 var banuser = $('.banuser');

 banuser.attr('value', username);

}

            </script>
</div>
<!--end::Container-->
