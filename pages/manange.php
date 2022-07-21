<?php
ob_start();

include '../includes/connection.php';
include '../includes/funtions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']))
{
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

    if ($role == "Reseller")
    {
        die('Resellers Not Allowed Here');
		
    }

if ($role != "developer" && $role != "seller")
{
    die("Must Upgrade To Manage Accounts");
}


?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
<button data-bs-toggle="modal" type="button" data-bs-target="#create-account" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create Account</button>

<div id="create-account" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Add Accounts</h4>
                                            <!--begin::Close-->
                                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                        <span class="svg-icon svg-icon-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                            <!--end::Close-->                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Role: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="If reseller, account will be able to create as many keys as their balance allows. Balance can be given manually by you by editing account after it's made, or your reseller can purchase their balance. If manager, the account is locked to that certain application and can do just about everything except rename, pause, refresh secret, and delete application."></i></label>
                                                        <select name="role" class="form-control"><option value="Reseller">Reseller</option><option value="Manager">Manager</option></select>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Application:</label>
                                                        <select name="app" class="form-control"><?php
$username = $_SESSION['username'];
($result = mysqli_query($link, "SELECT * FROM `apps` WHERE `owner` = '$username'")) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {
        echo "  <option>" . $row["name"] . "</option>";
    }
}

?></select>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Username:</label>
                                                        <input type="text" class="form-control" placeholder="Username for account you manage" name="username" required>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Email:</label>
                                                        <input type="text" class="form-control" placeholder="Email for account you manage" name="email" required>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Account Password:</label>
                                                        <input type="password" class="form-control" placeholder="Password for account you manage" name="pw" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Allowed License Levels:</label>
                                                        <input type="text" class="form-control" placeholder="Enter Levels In Format: 1|2|3, Leave It Blank For All Levels" name="keylevels">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="createacc">Add</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>
                    <?php

if (isset($_POST['createacc']))
{
    $role = sanitize($_POST['role']);

    $app = sanitize($_POST['app']);
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['pw']);
    $keylevels = sanitize($_POST['keylevels']) ?? "N/A";


    $pass_encrypted = password_hash($password, PASSWORD_BCRYPT);
    $owner = $_SESSION['username'];

    $user_check = mysqli_query($link, "SELECT `username` FROM `accounts` WHERE `username` = '$username'") or die(mysqli_error($link));
    $do_user_check = mysqli_num_rows($user_check);

    if ($do_user_check > 0)
    {
        error("Username already taken!");
        echo '<meta http-equiv="refresh" content="2">';
        return;
    }
    $email_check = mysqli_query($link, "SELECT `username` FROM `accounts` WHERE `email` = '$email'") or die(mysqli_error($link));
    $do_email_check = mysqli_num_rows($email_check);
    if ($do_email_check > 0)
    {
        error("Email already taken!");
        echo '<meta http-equiv="refresh" content="2">';
        return;
    }

    mysqli_query($link, "INSERT INTO `accounts` (`username`, `email`, `password`, `ownerid`, `role`, `app`, `owner`, `img`, `balance`, `keylevels`) VALUES ('$username','$email','$pass_encrypted','','$role','$app','$owner','https://i.imgur.com/TrwYFBa.png', '0|0|0|0|0|0', '$keylevels')") or die(mysqli_error($link));
    success("Successfully created account!");
    echo '<meta http-equiv="refresh" content="2">';
}

?>

<br><br>
<table id="kt_datatable_manageaccs" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Username</th>
        <th>Role</th>
        <th>Application</th>
        <th>Balance</th>
        <th>Allowed Levels</th>
        <th>Action</th>
        </tr>
    </thead>

    
    <tbody>
<?php
($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `owner` = '" . $_SESSION['username'] . "'")) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {

        echo "<tr>";

        echo "  <td>" . $row["username"] . "</td>";

        echo "  <td>" . $row["role"] . "</td>";

        echo "  <td>" . $row["app"] . "</td>";

        if ($row["role"] == "Manager")
        {
            echo "  <td>N/A</td>";
        }
        else
        {
            echo "  <td>" . $row["balance"] . "</td>";
        }
        echo " <td>" . $row["keylevels"] . "</td>";
                // echo "  <td>". $row["status"]. "</td>";
        echo '<td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu"><form method="post">
                                                <button class="dropdown-item" name="deleteacc" value="' . $row['username'] . '">Delete</button>
												<button class="dropdown-item" name="editacc" value="' . $row['username'] . '">Edit</button></div></td></tr></form>';

    }

}

?>
                                        </tbody>


</table>

<?php
if (isset($_POST['deleteacc']))
{
    $account = sanitize($_POST['deleteacc']);
    mysqli_query($link, "DELETE FROM `accounts` WHERE `owner` = '" . $_SESSION['username'] . "' AND `username` = '$account'");
    if (mysqli_affected_rows($link) > 0)
    {
        success("Account Successfully Deleted!");
        echo "<meta http-equiv='Refresh' Content='2'>";
    }
    else
    {
        error("Failed To Delete Account!");
    }
}

if (isset($_POST['editacc']))
{
    $account = sanitize($_POST['editacc']);

    $result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$account' AND `owner` = '" . $_SESSION['username'] . "'");
    if (mysqli_num_rows($result) == 0)
    {
        error("Account not Found!");
        echo "<meta http-equiv='Refresh' Content='2'>";
        return;
    }

    $row = mysqli_fetch_array($result);

    $keylevels = $row['keylevels'];

    $balance = $row["balance"];

    $balance = explode("|", $balance);

    $day = $balance[0];

    $week = $balance[1];

    $month = $balance[2];

    $threemonth = $balance[3];

    $sixmonth = $balance[4];

    $life = $balance[5];

    

    echo '<div id="edit-account" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">	
                                            <h4 class="modal-title">Edit Account</h4>
                                                
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
                                                        <label for="recipient-name" class="control-label">Day Balance: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of day keys account can create"></i></label>
                                                        <input type="text" class="form-control" name="daybalance" value="' . $day . '" required>
														<input type="hidden" name="account" value="' . $account . '">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Week Balance: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of week keys account can create"></i></label>
                                                        <input type="text" class="form-control" name="weekbalance" value="' . $week . '" required>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Month Balance: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of month keys account can create"></i></label>
                                                        <input type="text" class="form-control" name="monthbalance" value="' . $month . '" required>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Three Month Balance: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of three-month keys account can create"></i></label>
                                                        <input type="text" class="form-control" name="threemonthbalance" value="' . $threemonth . '" required>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Six Month Balance: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of six-month keys account can create"></i></label>
                                                        <input type="text" class="form-control" name="sixmonthbalance" value="' . $sixmonth . '" required>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Lifetime Balance: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of lifetime keys account can create"></i></label>
                                                        <input type="text" class="form-control" name="lifebalance" value="' . $life . '" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Allowed License Levels:</label>
                                                        <input type="text" class="form-control" name="keylevels" placeholder="Enter Levels In Format: 1|2|3, Leave It Blank For All Levels" value="' . $keylevels . '">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Email:</label>
                                                        <input type="email" class="form-control" name="email" placeholder="Enter new email">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Password:</label>
                                                        <input type="password" class="form-control" name="pw" placeholder="Enter new password">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" onClick="window.location.href=window.location.href" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button class="btn btn-danger" name="saveacc">Save</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>';
}

if (isset($_POST['saveacc']))
{
    $account = sanitize($_POST['account']);

    $day = sanitize($_POST['daybalance']);
    $week = sanitize($_POST['weekbalance']);
    $month = sanitize($_POST['monthbalance']);
    $threemonth = sanitize($_POST['threemonthbalance']);
    $sixmonth = sanitize($_POST['sixmonthbalance']);
    $lifetime = sanitize($_POST['lifebalance']);
    $keylevels = sanitize($_POST['keylevels']) ?? "N/A";
	
	$email = sanitize($_POST['email']);
	$pw = sanitize($_POST['pw']);
	
	if(!empty($email))
	{
		$email_check = mysqli_query($link, "SELECT `username` FROM `accounts` WHERE `email` = '$email'") or die(mysqli_error($link));
		$do_email_check = mysqli_num_rows($email_check);
		if ($do_email_check > 0)
		{
			error("Email already taken!");
			echo '<meta http-equiv="refresh" content="5">';
			return;
		}
		mysqli_query($link, "UPDATE `accounts` SET email = '$email' WHERE `username` = '$account' AND `owner` = '" . $_SESSION['username'] . "'");
	}
	if(!empty($pw))
	{	
		$pw = password_hash($pw, PASSWORD_BCRYPT);
		mysqli_query($link, "UPDATE `accounts` SET password = '$pw' WHERE `username` = '$account' AND `owner` = '" . $_SESSION['username'] . "'");
	}

    $balance = $day . '|' . $week . '|' . $month . '|' . $threemonth . '|' . $sixmonth . '|' . $lifetime;

    mysqli_query($link, "UPDATE `accounts` SET balance = '$balance', keylevels = '$keylevels' WHERE `username` = '$account' AND `owner` = '" . $_SESSION['username'] . "'");

    success("Successfully Updated Settings!");
    echo "<meta http-equiv='Refresh' Content='2'>";
}
?>

</div>
<!--end::Container-->
