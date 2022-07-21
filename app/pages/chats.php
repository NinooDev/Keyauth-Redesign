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
function time2str($date)
{
    $now = time();
    $diff = $now - $date;
    if ($diff < 60)
    {
        return sprintf($diff > 1 ? '%s seconds' : 'second', $diff);
    }
    $diff = floor($diff / 60);
    if ($diff < 60)
    {
        return sprintf($diff > 1 ? '%s minutes' : 'minute', $diff);
    }
    $diff = floor($diff / 60);
    if ($diff < 24)
    {
        return sprintf($diff > 1 ? '%s hours' : 'hour', $diff);
    }
    $diff = floor($diff / 24);
    if ($diff < 7)
    {
        return sprintf($diff > 1 ? '%s days' : 'day', $diff);
    }
    if ($diff < 30)
    {
        $diff = floor($diff / 7);
        return sprintf($diff > 1 ? '%s weeks' : 'week', $diff);
    }
    $diff = floor($diff / 30);
    if ($diff < 12)
    {
        return sprintf($diff > 1 ? '%s months' : 'month', $diff);
    }
    $diff = date('Y', $now) - date('Y', $date);
    return sprintf($diff > 1 ? '%s years' : 'year', $diff);
}

function deleteMessage($id, $secret = null)
{
	global $link;
	$id = sanitize($id);
	
    mysqli_query($link, "DELETE FROM `chatmsgs` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `id` = '$id'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function muteUser($user, $time, $secret = null)
{
	global $link;
	$user = sanitize($user);
	$time = sanitize($time);
	
	$result = mysqli_query($link, "SELECT * FROM `users` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `username` = '$user'");
    if (mysqli_num_rows($result) == 0)
    {
        return 'missing';
    }
    mysqli_query($link, "INSERT INTO `chatmutes` (`user`, `time`, `app`) VALUES ('$user','$time','" . ($secret ?? $_SESSION['app']) . "')");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function unMuteUser($user, $secret = null)
{
	global $link;
	$user = sanitize($user);
	
	mysqli_query($link, "DELETE FROM `chatmutes` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `user` = '$user'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function clearChannel($channel, $secret = null)
{
	global $link;
	$channel = sanitize($channel);
	
	mysqli_query($link, "DELETE FROM `chatmsgs` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `channel` = '$channel'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function createChannel($name, $delay, $secret = null)
{
	global $link;
	$name = sanitize($name);
	$delay = sanitize($delay);
	
	mysqli_query($link, "INSERT INTO `chats` (`name`, `delay`, `app`) VALUES ('$name','$delay','" . ($secret ?? $_SESSION['app']) . "')");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function deleteChannel($name, $secret = null)
{
	global $link;
	$name = sanitize($name);
	
	mysqli_query($link, "DELETE FROM `chats` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `name` = '$name'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}

?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
<form method="POST">
<button data-bs-toggle="modal" type="button" data-bs-target="#create-channel" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create Channel</button>  
<button data-bs-toggle="modal" type="button" data-bs-target="#clear-channel" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-cloud-upload-alt fa-sm text-white-50"></i> Clear channel</button> 
<button data-bs-toggle="modal" type="button" data-bs-target="#unmute-user" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-undo fa-sm text-white-50"></i> Unmute User</button>
</form>
	

<div id="create-channel" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Add Channels</h4>

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

                                                        <input class="form-control" name="name" placeholder="Chat channel name" required>

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Chat cooldown Unit:</label>

                                                        <select name="unit" class="form-control"><option value="1">Seconds</option><option value="60">Minutes</option><option value="3600">Hours</option><option value="86400">Days</option><option value="604800">Weeks</option><option value="2629743">Months</option><option value="31556926">Years</option><option value="315569260">Lifetime</option></select>

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Chat cooldown: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Delay users will have to wait to send their next message"></i></label>

                                                        <input name="delay" type="number" class="form-control" placeholder="Multiplied by selected delay unit" required>

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button class="btn btn-danger" name="addchannel">Add</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>

									

									<div id="unmute-user" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Unmute User</h4>

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

                                                        <select class="form-control" name="user">

														<?php
($result = mysqli_query($link, "SELECT * FROM `chatmutes` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
$rows = array();
while ($r = mysqli_fetch_assoc($result))
{
    $rows[] = $r;
}
foreach ($rows as $row)
{
?>

														<option><?php echo $row["user"]; ?></option>

														<?php
} ?>

														</select>

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button class="btn btn-danger" name="unmuteuser">Unmute</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>

					

<div id="clear-channel" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Clear Channel</h4>

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

                                                        <label for="recipient-name" class="control-label">Channel name:</label>

                                                        <select class="form-control" name="channel">

														<?php
($result = mysqli_query($link, "SELECT * FROM `chats` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
$rows = array();
while ($r = mysqli_fetch_assoc($result))
{
    $rows[] = $r;
}
foreach ($rows as $row)
{
?>

														<option><?php echo $row["name"]; ?></option>

														<?php
} ?>

														</select>

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button class="btn btn-danger" name="clearchannel">Clear</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>

                    <?php
if (isset($_POST['addchannel']))
{
    if ($_SESSION['role'] != "seller")
    {
        error("You must upgrade to seller to create chat channels");
    }
	else
	{
		$unit = sanitize($_POST['unit']);
		$delay = sanitize($_POST['delay']);
		$delay = $delay * $unit;
		$resp = createChannel($_POST['name'], $delay);
		switch ($resp)
		{
			case 'failure':
				error("Failed to create channel!");
				break;
			case 'success':
				success("Successfully created channel!");
                echo "<meta http-equiv='Refresh' Content='2'>";
				break;
			default:
				error("Unhandled Error! Contact us if you need help");
				break;
		}
	}
}
?>
<div id="mute-user" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

<div class="modal-dialog">

    <div class="modal-content">

        <div class="modal-header d-flex align-items-center">

            <h4 class="modal-title">Mute User</h4>

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

                    <label for="recipient-name" class="control-label">Unit Of Time Muted:</label>

                    <select name="muted" class="form-control"><option value="86400">Days</option><option value="60">Minutes</option><option value="3600">Hours</option><option value="1">Seconds</option><option value="604800">Weeks</option><option value="2629743">Months</option><option value="31556926">Years</option><option value="315569260">Lifetime</option></select>

                    <input type="hidden" class="muteuser" name="user">

                </div>

                <div class="form-group">

                    <label for="recipient-name" class="control-label">Time Muted:</label>

                    <input class="form-control" name="time" placeholder="Multiplied by selected unit of time muted">

                </div>

        </div>

        <div class="modal-footer">

            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            <button class="btn btn-danger" name="muteuser">Mute</button>

            </form>

        </div>

    </div>

</div>

</div>
<table id="kt_datatable_chats" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Name</th>
        <th>Delay</th>
        <th>Action</th>
        </tr>
    </thead>

    <tbody>



<?php
if ($_SESSION['app'])
{
($result = mysqli_query($link, "SELECT * FROM `chats` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
$rows = array();
while ($r = mysqli_fetch_assoc($result))
{
$rows[] = $r;
}
foreach ($rows as $row)
{
$chan = $row['name'];
?>



                <tr>



                <td><?php echo $chan; ?></td>

                

                <td><?php echo time2str(time() - $row["delay"]); ?></td>                                                    

                

        <form method="POST"><td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            Manage

        </button>

        <div class="dropdown-menu">

            <button class="dropdown-item" name="deletechan" value="<?php echo $chan; ?>">Delete</button>

            <button class="dropdown-item" name="editchan" value="<?php echo $chan; ?>">Edit</button></div></td></tr></form>

<?php
}
}
?>

    </tbody>

</table>

<br><br>


<table id="kt_datatable_messages" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Author</th>
        <th>Message</th>
        <th>Time Sent</th>
        <th>Channel</th>
        <th>Action</th>
        </tr>
    </thead>


<tbody>

<?php
if ($_SESSION['app'])
{
($result = mysqli_query($link, "SELECT * FROM `chatmsgs` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
$rows = array();
while ($r = mysqli_fetch_assoc($result))
{
$rows[] = $r;
}
foreach ($rows as $row)
{
$user = $row['author'];
?>



                <tr>



                <td><?php echo $user; ?></td>

                

                <td><?php echo $row["message"]; ?></td>

                

                <td><?php if(!$row["timestamp"] == NULL) { echo date('Y/m/d H:i', $row["timestamp"]); } else { echo "N/A"; }?></td>

                

                <td><?php echo $row["channel"]; ?></td>

                

        <form method="POST"><td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            Manage

        </button>

        <div class="dropdown-menu">

            <button class="dropdown-item" name="deletemsg" value="<?php echo $row["id"]; ?>">Delete</button>

            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#mute-user" onclick="muteuser('<?php echo $user; ?>')">Mute</a></div></td></tr></form>

<?php
}
}
?>

    </tbody>

</table>

<?php
if (isset($_POST['deletemsg']))
{
	$resp = deleteMessage($_POST['deletemsg']);
    switch ($resp)
    {
        case 'failure':
			error("Failed to delete message!");
			break;
		case 'success':
			success("Successfully deleted message!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['muteuser']))
{
    $muted = sanitize($_POST['muted']);
    $time = sanitize($_POST['time']);
    $time = $time * $muted + time();
	
	$resp = muteUser($_POST['user'], $time);
    switch ($resp)
    {
		case 'missing':
			error("User doesn\'t exist!");
			break;
        case 'failure':
			error("Failed to mute user!");
			break;
		case 'success':
			success("Successfully muted user!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['unmuteuser']))
{
	$resp = unMuteUser($_POST['user']);
    switch ($resp)
    {
        case 'failure':
			error("Failed to unmute user!");
			break;
		case 'success':
			success("Successfully unmuted user!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['clearchannel']))
{
    $resp = clearChannel($_POST['channel']);
    switch ($resp)
    {
        case 'failure':
			error("Failed to clear channel!");
			break;
		case 'success':
			success("Successfully cleared channel!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['editchan']))
{
    $chan = sanitize($_POST['editchan']);
    $result = mysqli_query($link, "SELECT * FROM `chats` WHERE `name` = '$chan' AND `app` = '" . $_SESSION['app'] . "'");
    if (mysqli_num_rows($result) == 0)
    {
        mysqli_close($link);
       error("Channel not Found!");
        echo "<meta http-equiv='Refresh' Content='2'>";
        return;
    }
?>

		<div id="edit-user" class="modal show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true"o ydo >

                        <div class="modal-dialog">

                            <div class="modal-content">

                                <div class="modal-header d-flex align-items-center">

									<h4 class="modal-title">Edit Channel</h4>

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

                                            <label for="recipient-name" class="control-label">Chat cooldown Unit:</label>

                                            <select name="unit" class="form-control"><option value="1">Seconds</option><option value="60">Minutes</option><option value="3600">Hours</option><option value="86400">Days</option><option value="604800">Weeks</option><option value="2629743">Months</option><option value="31556926">Years</option><option value="315569260">Lifetime</option></select>

                                        </div>

										<div class="form-group">

                                            <label for="recipient-name" class="control-label">Chat cooldown: <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="Delay users will have to wait to send their next message"></i></label>

                                            <input name="delay" type="number" class="form-control" placeholder="Multiplied by selected delay unit" required>

                                        </div>
                                </div>

                                <div class="modal-footer">

                                    <button type="button" onClick="window.location.href=window.location.href" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                    <button class="btn btn-danger" value="<?php echo $chan; ?>" name="savechan">Save</button>

									</form>

                                </div>

                            </div>

                            


						


						<?php
}
if (isset($_POST['savechan']))
{
    $chan = sanitize($_POST['savechan']);
    $unit = sanitize($_POST['unit']);
    $delay = sanitize($_POST['delay']);
    $delay = $delay * $unit;
    mysqli_query($link, "UPDATE `chats` SET `delay` = '$delay' WHERE `app` = '" . $_SESSION['app'] . "' AND `name` = '$chan'");
    if (mysqli_affected_rows($link) > 0) // check query impacted something, else show error
    
    {
       success("Successfully updated channel!");
        echo "<meta http-equiv='Refresh' Content='2'>";
    }
    else
    {
       error("Failed To update channel!");
    }
}
if (isset($_POST['deletechan']))
{
    $resp = deleteChannel($_POST['deletechan']);
    switch ($resp)
    {
        case 'failure':
			error("Failed to delete channel!");
			break;
		case 'success':
			success("Successfully deleted channel!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
?>

<script>

                        

		function muteuser(key) {

		 var muteuser = $('.muteuser');

		 muteuser.attr('value', key);

      }
	  
 </script>
</div>




<!--end::Container-->
