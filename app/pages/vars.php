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

function add($name, $data, $authed, $secret = null)
{
	global $link;
	$name = sanitize($name);
	$data = sanitize($data);
	$authed = sanitize($authed);
	
	$var_check = mysqli_query($link, "SELECT * FROM `vars` WHERE `varid` = '$name' AND `app` = '".($secret ?? $_SESSION['app'])."'");
	if (mysqli_num_rows($var_check) > 0)
	{
		return 'exists';
	}
	mysqli_query($link, "INSERT INTO `vars`(`varid`, `msg`, `app`, `authed`) VALUES ('$name','$data','".($secret ?? $_SESSION['app'])."', '$authed')");
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
	
	mysqli_query($link, "DELETE FROM `vars` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function deleteSingular($var, $secret = null)
{
	global $link;
	$var = sanitize($var);
	
    mysqli_query($link, "DELETE FROM `vars` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `varid` = '$var'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function edit($name, $data, $authed, $secret = null)
{
	global $link;
	$name = sanitize($name);
	$data = sanitize($data);
	$authed = sanitize($authed);
	
	mysqli_query($link, "UPDATE `vars` SET `msg` = '$data', `authed` = '$authed' WHERE `varid` = '$name' AND `app` = '" . ($secret ?? $_SESSION['app']) . "'");
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
	
<form method="post">
<button data-bs-toggle="modal" type="button" data-bs-target="#create-variable" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create Variable</button>  
<button name="delvars" data-bs-toggle="modal" type="button" data-bs-target="#deleteallvars" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete All Variables</button></form>
<br>
<div id="create-variable" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">Add Variables</h4>
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
                        <label for="recipient-name" class="control-label">Variable Name:</label>
                        <input type="text" class="form-control" name="varname" placeholder="Name To Refrence Variable By" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Variable Data: <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="Get string from KeyAuth server, where it's more secure"></i></label>
                        <input type="text" class="form-control" placeholder="Value of Variable" name="vardata" required>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" name="authed" type="checkbox" id="flexCheckChecked" checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        Authenticated <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="If checked, KeyAuth will force user to be logged in to use."></i>
                    </label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-danger" name="genvar">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="deleteallvars">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete All Variables</h2>

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
                <p> Are you sure you want to delete all variables? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="delvars" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<table id="kt_datatable_subs" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Variable Name</th>
        <th>Variable Data</th>
        <th>Authenticated</th>
        <th>Action</th>
        </tr>
    </thead>

    <tbody>
<?php
if ($_SESSION['app'])
{
    ($result = mysqli_query($link, "SELECT * FROM `vars` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result))
        {

            echo "<tr>";

            echo "  <td>" . $row["varid"] . "</td>";

            echo "  <td>" . $row["msg"] . "</td>";

            echo "  <td>" . (($row["authed"] ? 1 : 0) ? 'True' : 'False') . "</td>";

            echo '<td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu"><form method="post">
                                                <button class="dropdown-item" name="deletevar" value="' . $row['varid'] . '">Delete</button>
												<button class="dropdown-item" name="editvar" value="' . $row['varid'] . '">Edit</button></div></td></tr></form>';

        }

    }

}

?>
                                        </tbody>

</table>
<?php
if (isset($_POST['genvar']))
{	
	$authed = sanitize($_POST['authed']) == NULL ? 0 : 1;
	$resp = add($_POST['varname'], $_POST['vardata'], $authed);
    switch ($resp)
    {
		case 'exists':
			error("Variable name already exists!");
			break;
        case 'failure':
			error("Failed to create variable!");
			break;
		case 'success':
			success("Successfully created variable!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}

if (isset($_POST['delvars']))
{
    $resp = deleteAll();
    switch ($resp)
    {
        case 'failure':
			error("Failed to delete all variables!");
			break;
		case 'success':
			success("Successfully deleted all variables!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
				
if (isset($_POST['deletevar']))
{
    $resp = deleteSingular($_POST['deletevar']);
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

if (isset($_POST['editvar'])) // edit modal

{
    $variable = sanitize($_POST['editvar']);

    $result = mysqli_query($link, "SELECT * FROM `vars` WHERE `varid` = '$variable' AND `app` = '" . $_SESSION['app'] . "'");
    if (mysqli_num_rows($result) == 0)
    {
        mysqli_close($link);
        error("Variable not Found!");
        echo "<meta http-equiv='Refresh' Content='2'>";
        return;
    }

    $row = mysqli_fetch_array($result);

    $data = $row["msg"];

    echo '<div id="edit-var" class="modal show" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Edit Variable</h4>
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
                                                        <label for="recipient-name" class="control-label">Variable Data:</label>
                                                        <input type="text" class="form-control" name="msg" value="' . $data . '" required>
														<input type="hidden" name="variable" value="' . $variable . '">
                                                    </div>
													<div class="form-check">
													<input class="form-check-input" name="authed" type="checkbox" id="flexCheckChecked" checked>
													<label class="form-check-label" for="flexCheckChecked">
														Authenticated <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="If checked, KeyAuth will force user to be logged in to use."></i>
													</label>
													</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onClick="window.location.href=window.location.href" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="savevar">Save</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>';
}

if (isset($_POST['savevar']))
{
    $authed = sanitize($_POST['authed']) == NULL ? 0 : 1;
	$resp = edit($_POST['variable'], $_POST['msg'], $authed);
    switch ($resp)
    {
        case 'failure':
			error("Failed to edit variable!");
			break;
		case 'success':
			success("Successfully edited variable!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
?>




</div>
<!--end::Container-->
