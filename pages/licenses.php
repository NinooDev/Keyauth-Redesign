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
         <button type="button" data-bs-toggle="modal" data-bs-target="#create-keys" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create keys</button>  
         <button data-bs-toggle="modal" type="button" data-bs-target="#import-keys" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-cloud-upload-alt fa-sm text-white-50"></i> Import keys</button> 
         <button data-bs-toggle="modal" type="button" data-bs-target="#comp-keys" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-clock fa-sm text-white-50"></i> Add Time</button><br><br>
         <button name="dlkeys" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-download fa-sm text-white-50"></i> Download All keys</button> 
         <button type="button" data-bs-toggle="modal" data-bs-target="#delete-allkeys" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete All keys</button>  
         <button type="button" data-bs-toggle="modal" data-bs-target="#delete-allunusedkeys" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete All Unused Keys</button> 
         <button type="button" data-bs-toggle="modal" data-bs-target="#delete-allusedkeys" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete All Used Keys</button>

    </form>

<?php
    if (isset($_SESSION['keys_array']))
    {
        $list = $_SESSION['keys_array'];
        $keys = NULL;
        for ($i = 0;$i < count($list);$i++)
        {
            $keys .= "" . $list[$i] . "<br>";
        }
        echo "<div class=\"card\"> <div class=\"card-body\"> $keys </div> </div> <br>";
        unset($_SESSION['keys_array']);
    }
?>

<div class="modal fade" tabindex="-1" id="create-keys">
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
											<?php
$list = $_SESSION['licensePresave'];
$format = $list[0];
$amt = $list[1];
$lvl = $list[2];
$note = $list[3];
$dur = $list[4];
?>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Amount:</label>
                                                        <input type="number" class="form-control" name="amount" placeholder="Default 1" value="<?php if (!is_null($amt))
{
    echo $amt;
} ?>">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Key Mask: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Format keys are in. You can do custom by putting whatever, or do capital X or lowercase X for random character"></i></label>
                                                        <input type="text" class="form-control" value="<?php if (!is_null($format))
{
    echo $format;
}
else
{
    echo "XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX";
} ?>" placeholder="Key Format. X is capital random char, x is lowercase" name="mask" required maxlength="49">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">License Level: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="This needs to coordinate to the level of subscription you want to give to user when they redeem license. If it's blank, go to subscriptions tab and create subscription"></i></label>
                                                        <select name="level" class="form-control">
														<?php
($result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `app` = '" . $_SESSION['app'] . "'"));
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_array($result))
    {
?>
																	<option <?=$lvl == $row["level"] ? ' selected="selected"' : ''; ?>><?php echo $row["level"]; ?></option>
																	<?php
    }
}
?>
														</select>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">License Note:</label>
                                                        <input type="text" class="form-control" name="note" placeholder="Optional, e.g. this license was for Joe" value="<?php if (!is_null($note))
{
    echo $note;
} ?>">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">License Expiry Unit:</label>
                                                        <select name="expiry" class="form-control"><option value="86400">Days</option><option value="60">Minutes</option><option value="3600">Hours</option><option value="1">Seconds</option><option value="604800">Weeks</option><option value="2629743">Months</option><option value="31556926">Years</option><option value="315569260">Lifetime</option></select>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">License Duration: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="When the key is redeemed, a subscription with the duration of the key will be added to the user who redeemed the key."></i></label>
                                                        <input name="duration" type="number" class="form-control" placeholder="Multiplied by selected Expiry unit" value="<?php if (!is_null($dur))
{
    echo $dur;
} ?>" required>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="genkeys">Add</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>
                                    <div class="modal fade" tabindex="-1" id="import-keys">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Import Licenses</h4>
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
                                                        <label for="recipient-name" class="control-label">Keys: <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="Make sure you have a subscription created that matches each level of the keys you're importing."></i></label>
                                                        <input class="form-control" name="keys" placeholder="Format: KEYHERE,LVLHERE,DAYSHERE|KEYHERE,LVLHERE,DAYSHERE">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="importkeys">Import</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>
									
<div class="modal fade" tabindex="-1" id="comp-keys">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Add Time</h4>
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
                                                        <label for="recipient-name" class="control-label">Unit Of Time To Add:</label>
                                                        <select name="expiry" class="form-control"><option value="86400">Days</option><option value="60">Minutes</option><option value="3600">Hours</option><option value="1">Seconds</option><option value="604800">Weeks</option><option value="2629743">Months</option><option value="31556926">Years</option><option value="315569260">Lifetime</option></select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Time To Add: <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="If the key is used, this will do nothing. Used keys are turned into users so if you want to add time to a user, go to users tab and click extend user(s)"></i></label>
                                                        <input class="form-control" name="time" placeholder="Multiplied by selected unit of time">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="addtime">Add</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>
                                    <div class="modal fade" tabindex="-1" id="ban-key">
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
                                                    <!--end::Close-->                                                  </div>
                                            <div class="modal-body">
                                                <form method="post"> 
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Ban reason:</label>
                                                        <input type="text" class="form-control" name="reason" placeholder="Reason for ban" required>
														<input type="hidden" class="bankey" name="key">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="bankey">Ban</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>

<!--begin::Modal - Delete all keys-->
<div class="modal fade" tabindex="-1" id="delete-allkeys">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete All Keys</h2>

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
                <p> Are you sure you want to delete all keys? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="delkeys" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Delete all keys-->
<!--begin::Modal - Delete all unused keys-->
<div class="modal fade" tabindex="-1" id="delete-allunusedkeys">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete All Unused Keys</h2>

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
                <p> Are you sure you want to delete all unused keys? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="deleteallunused" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Delete all unused keys-->
<!--begin::Modal - Delete all used keys-->
<div class="modal fade" tabindex="-1" id="delete-allusedkeys">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete All Used Keys</h2>

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
                <p> Are you sure you want to delete all used keys? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="deleteallused" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Delete all used keys-->
<table id="kt_datatable_licenses" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
            <th>Key</th>
            <th>Creation Date</th>
            <th>Generated By</th>
            <th>Duration</th>
            <th>Note</th>
            <th>Used On</th>
            <th>Used By</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

<?php
if ($_SESSION['app'])
{
    $result = mysqli_query($link, "SELECT * FROM `keys` WHERE `app` = '" . $_SESSION['app'] . "'");
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
													
													<td><?php echo date('Y/m/d H:i', $row["gendate"])?></td>

                                                    <td><?php echo $row["genby"]; ?></td>
                                                    
                                                    <td><?php echo $row["expires"] / 86400 ?> Day(s)</td>
                                                    <td><?php echo $row["note"] ?? "N/A"; ?></td>
													
													<td><?php if(!$row["usedon"] == NULL) { echo date('Y/m/d H:i', $row["usedon"]); } else { echo "N/A"; } ?></td>
													<td><?php echo $row["usedby"] ?? "N/A"; ?></td>
                                                    <td><label class="<?php echo $badge; ?>"><?php echo $row['status']; ?></label></td>

                                            <form method="POST"><td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" name="deletekey" value="<?php echo $key; ?>">Delete</button>
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ban-key" onclick="bankey('<?php echo $key; ?>')">Ban</a>
                                                <button class="dropdown-item" name="unbankey" value="<?php echo $key; ?>">Unban</button>
                                                <div class="dropdown-divider"></div>
												<button class="dropdown-item" name="editkey" value="<?php echo $key; ?>">Edit</button></div></td></tr></form>
<?php
    }
}
?>
                                        </tbody>
</table>
            
                
                <?php
if (isset($_POST['deletekey']))
{
	$resp = deleteSingular($_POST['deletekey']);
	switch($resp)
	{
		case 'failure':
			error("Failed to delete license!");
			break;
		case 'success':
			success("Successfully deleted license!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['bankey']))
{
    $resp = ban($_POST['key'], $_POST['reason']);
	switch($resp)
	{
		case 'failure':
			error("Failed to ban license!");
			break;
		case 'success':
			success("Successfully banned license!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['unbankey']))
{
	$resp = unban($_POST['unbankey']);
	switch($resp)
	{
		case 'failure':
			error("Failed to unban license!");
			break;
		case 'success':
			success("Successfully unbanned license!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['editkey']))
{
    $key = sanitize($_POST['editkey']);
    $result = mysqli_query($link, "SELECT * FROM `keys` WHERE `key` = '$key' AND `app` = '" . $_SESSION['app'] . "'");
    if (mysqli_num_rows($result) == 0)
    {
        mysqli_close($link);
        error("Key not Found!");
        echo "<meta http-equiv='Refresh' Content='2'>";
        return;
    }
    $row = mysqli_fetch_array($result);
?>
<div id="edit-key" class="modal show" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true">

                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Edit License</h4>
                                                    <!--begin::Close-->
                                                    <div class="btn btn-sm btn-icon btn-active-color-primary" onClick="window.location.href=window.location.href">
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    <!--end::Close-->                                                </div>
                                            <div class="modal-body">
                                                <form method="post"> 
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Key Level:</label>
                                                        <input type="text" class="form-control" name="level" value="<?php echo $row['level']; ?>" required>
														<input type="hidden" name="key" value="<?php echo $key; ?>">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">License Duration Unit:</label>
                                                        <select name="expiry" class="form-control"><option value="86400">Days</option><option value="60">Minutes</option><option value="3600">Hours</option><option value="1">Seconds</option><option value="604800">Weeks</option><option value="2629743">Months</option><option value="31556926">Years</option><option value="315569260">Lifetime</option></select>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">License Duration: <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="Editing license duration after the license has been used will do nothing. Used licenses become users so you need to go to users tab and click extend user(s) instead"></i></label>
                                                        <input name="duration" type="number" class="form-control" placeholder="Multiplied by selected Expiry unit">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onClick="window.location.href=window.location.href" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="savekey">Save</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>
									<?php
}
if (isset($_POST['savekey']))
{
    $key = sanitize($_POST['key']);
    $level = sanitize($_POST['level']);
    $duration = sanitize($_POST['duration']);
    if (!empty($duration))
    {
        $expiry = sanitize($_POST['expiry']);
        $duration = $duration * $expiry;
        mysqli_query($link, "UPDATE `keys` SET `expires` = '$duration' WHERE `key` = '$key' AND `app` = '" . $_SESSION['app'] . "'");
    }
    mysqli_query($link, "UPDATE `keys` SET `level` = '$level' WHERE `key` = '$key' AND `app` = '" . $_SESSION['app'] . "'");
    success("Successfully Updated Settings!");
    echo "<meta http-equiv='Refresh' Content='2'>";
}


function license_masking($mask)
{
    $mask_arr = str_split($mask);
    $size_of_mask = count($mask_arr);
    for ($i = 0;$i < $size_of_mask;$i++)
    {
        if ($mask_arr[$i] === 'X')
        {
            $mask_arr[$i] = random_string_upper(1);
        }
        else if ($mask_arr[$i] === 'x')
        {
            $mask_arr[$i] = random_string_lower(1);
        }
    }
    return implode('', $mask_arr);
}
function createLicense($amount, $mask, $duration, $level, $note, $expiry = null)
{
	global $link;
	$amount = sanitize($amount);
	$mask = sanitize($mask);
	$duration = sanitize($duration);
	$level = sanitize($level);
	$note = sanitize($note);
	$expiry = sanitize($expiry);
	
	if ($amount > 100)
    {
        return 'max_keys';
    }
	if (!isset($amount))
    {
        $amount = 1;
    }
	if (!is_numeric($level))
    {
        $level = 1;
    }
	if ($_SESSION['role'] == "tester")
    {
        $result = mysqli_query($link, "SELECT * FROM `keys` WHERE `genby` = '" . $_SESSION['username'] . "'");
        $currkeys = mysqli_num_rows($result);
        if ($currkeys + $amount > 50)
        {
            return 'tester_limit';
        }
    }
	if(is_null($expiry))
	{
		$expiry = 86400; // set unit to day(s) if license expiry unit isn't specified (as it isn't with SellerAPI)
	}
	$duration = $duration * $expiry;
	if ($amount > 1 && strpos($mask, 'X') === false && strpos($mask, 'x') === false)
	{
		return 'dupe_custom_key';
	}
	$licenses = array();

    for ($i = 0;$i < $amount;$i++)
    {

        $license = license_masking($mask);
        mysqli_query($link, "INSERT INTO `keys` (`key`, `note`, `expires`, `status`, `level`, `genby`, `gendate`, `app`) VALUES ('$license',NULLIF('$note', ''), '$duration','Not Used','$level','" . ($_SESSION['username'] ?? 'SellerAPI') . "', '" . time() . "', '" . ($secret ?? $_SESSION['app']) . "')");
        $licenses[] = $license;
    }

    return $licenses;
}
function addTime($time, $expiry)
{
	global $link;
	$time = sanitize($time);
    $expiry = sanitize($expiry);
	
    $time = $time * $expiry;
    mysqli_query($link, "UPDATE `keys` SET `expires` = `expires`+$time WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `status` = 'Not Used'");
    if (mysqli_affected_rows($link) > 0)
    {
        return 'success';
    }
    else
    {
        return 'failure';
    }
}
if (isset($_POST['importkeys']))
{
    $keys = sanitize($_POST['keys']);
    $text = explode("|", $keys);
    str_replace('"', "", $text);
    str_replace("'", "", $text);
    foreach ($text as $line)
    {
        $array = explode(',', $line);
        $first = $array[0];
        if (!isset($first) || $first == '')
        {
            error("Invalid Format, please watch tutorial video!");
            echo "<meta http-equiv='Refresh' Content='2;'>";
            return;
        }
        $second = $array[1];
        if (!isset($second) || $second == '')
        {
           error("Invalid Format, please watch tutorial video!");
            echo "<meta http-equiv='Refresh' Content='2;'>";
            return;
        }
        $third = $array[2];
        if (!isset($third) || $third == '')
        {
          error("Invalid Format, please watch tutorial video!");
            echo "<meta http-equiv='Refresh' Content='2;'>";
            return;
        }
        $expiry = $third * 86400;
        mysqli_query($link, "INSERT INTO `keys` (`key`, `expires`, `status`, `level`, `genby`, `gendate`, `app`) VALUES ('$first','$expiry','Not Used','$second','" . $_SESSION['username'] . "','" . time() . "','" . $_SESSION['app'] . "')");
    }
    success("Successfully imported licenses!");
    echo "<meta http-equiv='Refresh' Content='2'>";
}
if (isset($_POST['addtime']))
{
	$resp = addTime($_POST['time'], $_POST['expiry']);
	switch($resp)
	{
		case 'failure':
			error("Failed to add time!");
			break;
		case 'success':
			success("Added time to unused licenses!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['dlkeys']))
{
    echo "<meta http-equiv='Refresh' Content='0; url=pages/license-download.php'>";
    // get all rows, put in text file, download text file, delete text file.
    
}
if (isset($_POST['delkeys']))
{
	$resp = deleteAll();
	switch($resp)
	{
		case 'failure':
			error("Didn\'t find any keys!");
			break;
		case 'success':
			success("Deleted All Keys!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['deleteallunused']))
{
	$resp = deleteAllUnused();
	switch($resp)
	{
		case 'failure':
			error("Didn\'t find any unused keys!");
			break;
		case 'success':
			success("Deleted All Unused Keys!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['deleteallused']))
{
	$resp = deleteAllUsed();
	switch($resp)
	{
		case 'failure':
			error("Didn\'t find any used keys!");
			break;
		case 'success':
			success("Deleted All Used Keys!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}

function deleteAll()
{
	global $link;
	
	mysqli_query($link, "DELETE FROM `keys` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
        return 'failure';
    }
}
function deleteAllUnused()
{
	global $link;
	
	mysqli_query($link, "DELETE FROM `keys` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `status` = 'Not Used'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
        return 'failure';
    }
}
function deleteAllUsed()
{
	global $link;
	
	mysqli_query($link, "DELETE FROM `keys` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `status` = 'Used'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
        return 'failure';
    }
}
function deleteSingular($key)
{
	global $link;
	$key = sanitize($key);
	mysqli_query($link, "DELETE FROM `subs` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `key` = '$key'"); // delete any subscriptions created with key
	mysqli_query($link, "DELETE FROM `keys` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `key` = '$key'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
        return 'failure';
    }
}
function ban($key, $reason)
{
	global $link;
	$key = sanitize($key);
	$reason = sanitize($reason);
	
	mysqli_query($link, "UPDATE `keys` SET `banned` = '$reason', `status` = 'Banned' WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `key` = '$key'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
        return 'failure';
    }
}
function unban($key)
{
	global $link;
	$key = sanitize($key);
	
	$result = mysqli_query($link, "SELECT * FROM `keys` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `key` = '$key'");
    if (mysqli_num_rows($result) == 0) // check if key exists
    {
        return 'missing';
    }
    $row = mysqli_fetch_array($result);
    $usedby = $row["usedby"];
    $status = "Used";
    if (is_null($usedby))
    {
        $status = "Not Used";
    }
    mysqli_query($link, "UPDATE `keys` SET `banned` = NULL, `status` = '$status' WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `key` = '$key'"); // update key from banned to its old status
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
        return 'failure';
    }
}





















    if (isset($_POST['genkeys']))
    {
        $key = createLicense($_POST['amount'], $_POST['mask'], $_POST['duration'], $_POST['level'], $_POST['note'], $_POST['expiry']);
        switch ($key)
        {
            case 'max_keys':
               error("You can only generate 100 licenses at a time");
            break;
            case 'tester_limit':
                error("Tester plan only allows for 50 licenses, please upgrade!");
            break;
            case 'dupe_custom_key':
                error("Can\'t do custom key with amount greater than one");
            break;
            default:
                mysqli_query($link, "UPDATE `accounts` SET `format` = '" . sanitize($_POST['mask']) . "',`amount` = '" . sanitize($_POST['amount']) . "',`lvl` = '" . sanitize($_POST['level']) . "',`note` = '" . sanitize($_POST['note']) . "',`duration` = '" . sanitize($_POST['duration']) . "' WHERE `username` = '" . $_SESSION['username'] . "'");
                if (sanitize($_POST['amount']) > 1)
                {
                    $_SESSION['keys_array'] = $key;
                    echo "<meta http-equiv='Refresh' Content='0;'>";
                }
                else
                {
                    echo "<script>
    navigator.clipboard.writeText('" . array_values($key) [0] . "');
    </script>";
                    success("License Created And Copied To Clipboard!");
                    echo "<meta http-equiv='Refresh' Content='2;'>";

                }
            break;
        }
    }
?>
<script>
                        
                        function bankey(key) {
                         var bankey = $('.bankey');
                         bankey.attr('value', key);
                      }
                                    </script>
<script src="../app/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="../app/assets/plugins/custom/datatables/licenses.js"></script>
</div>