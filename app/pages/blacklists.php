<?php
include '../../../includes/connection.php';
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


function add($data, $type, $secret = null)
{
	global $link;
	$data = sanitize($data);
	$type = sanitize($type);
	
	switch($type)
	{
		case 'IP Address':
			mysqli_query($link, "INSERT INTO `bans`(`ip`, `type`, `app`) VALUES ('$data','ip','" . ($secret ?? $_SESSION['app']) . "')");
			break;
		case 'Hardware ID':
			mysqli_query($link, "INSERT INTO `bans`(`hwid`, `type`, `app`) VALUES ('$data','hwid','" . ($secret ?? $_SESSION['app']) . "')");
			break;
		default:
			return 'invalid';
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
function deleteAll($secret = null)
{
	global $link;
	
	mysqli_query($link, "DELETE FROM `bans` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function deleteSingular($blacklist, $type, $secret = null)
{
	global $link;
	$blacklist = sanitize($blacklist);
	$type = sanitize($type);

	switch($type)
	{
		case 'ip':
			mysqli_query($link, "DELETE FROM `bans` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `ip` = '$blacklist'");
			break;
		case 'hwid':
			mysqli_query($link, "DELETE FROM `bans` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `hwid` = '$blacklist'");
			break;
		default:
			return 'invalid';
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

if (isset($_POST['addblack']))
{
	$resp = add($_POST['blackdata'], $_POST['blacktype']);
    switch ($resp)
    {
		case 'invalid':
			error("Invalid blacklist type!");
			break;
        case 'failure':
			error("Failed to add blacklist!");
			break;
		case 'success':
			success("Successfully added blacklist!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['delblacks']))
{
	$resp = deleteAll();
    switch ($resp)
    {
        case 'failure':
			error("Failed to delete all blacklists!");
			break;
		case 'success':
			success("Successfully deleted all blacklists!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}

if (isset($_POST['deleteblack']))
{
	$resp = deleteSingular($_POST['deleteblack'], $_POST['type']);
    switch ($resp)
    {
		case 'invalid':
			error("Invalid blacklist type!");
			break;
        case 'failure':
			error("Failed to delete blacklist!");
			break;
		case 'success':
			success("Successfully deleted blacklist!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}


?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
<form method="post">

<button data-bs-toggle="modal" type="button" data-bs-target="#create-blacklist" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create Blacklist</button>  
<button data-bs-toggle="modal" type="button" data-bs-target="#delete-blacklists" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete All Blacklists</button></form>
<br>
	


<div id="create-blacklist" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Add Blacklist</h4>

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

                                                        <label for="recipient-name" class="control-label">Blacklist Type:</label>

                                                        <select name="blacktype" class="form-control"><option>IP Address</option><option>Hardware ID</option></select>

                                                    </div>

													<div class="form-group">

                                                        <label for="recipient-name" class="control-label">Blacklist Data:</label>

                                                        <input type="text" class="form-control" placeholder="IP or HWID to blacklist" name="blackdata" required>

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button class="btn btn-danger" name="addblack">Add</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>


                                    
<div class="modal fade" tabindex="-1" id="delete-blacklists">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete All Blacklists</h2>

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
                <p> Are you sure you want to delete all blacklists? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="delblacks" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<table id="kt_datatable_logs" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Blacklist Data</th>
        <th>Blacklist Type</th>
        <th>Action</th>
        </tr>
    </thead>

    
    <tbody>

<?php
if ($_SESSION['app'])
{
    ($result = mysqli_query($link, "SELECT * FROM `bans` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result))
        {
            echo "<tr>";
            $data = $row["hwid"] ?? $row["ip"]; // display either hwid or IP, depending which one isn't null
            echo "  <td>" . $data . "</td>";
            echo "  <td>" . $row["type"] . "</td>";
            // echo "  <td>". $row["status"]. "</td>";
            echo '<td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                Manage

                                            </button>

                                            <div class="dropdown-menu"><form method="post">

                                                <button class="dropdown-item" name="deleteblack" value="' . $data . '">Delete</button><input type="hidden" name="type" value="' . $row["type"] . '"></div></td></tr></form>';
        }
    }
}
?>

                                        </tbody>


</table>



</div>
<!--end::Container-->
