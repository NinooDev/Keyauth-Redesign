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

function add($url, $authed)
{
    $role = $_SESSION["role"];
	global $link;
	$url = sanitize($url);
	$authed = sanitize($authed);
	
	if (!filter_var($url, FILTER_VALIDATE_URL))
    {
        return 'invalid';
    }
    $file = file_get_contents($url);
    $filesize = strlen($file);
    if ($filesize > 10000000 && $role == "tester")
    {
        error("Users with tester plan may only upload files up to 10MB. Paid plans may upload up to 50MB.");
        return;
    }
    else if ($filesize > 50000000 && $role == "developer")
    {
        error("File size limit is 50 MB.");
        return;
    }
    else if ($filesize > 75000000)
    {
        error("File size limit is 75 MB.");
        return;
    }
	$id = generateRandomNum();
	$fn = basename($url);
    $fs = formatBytes($filesize);
	mysqli_query($link, "INSERT INTO `files` (name, id, url, size, uploaddate, app, authed) VALUES ('$fn', '$id', '$url', '$fs', '" . time() . "', '" . ($secret ?? $_SESSION['app']) . "', '$authed')");
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
	
	mysqli_query($link, "DELETE FROM `files` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function deleteSingular($file, $secret = null)
{
	global $link;
	$file = sanitize($file);
	
    mysqli_query($link, "DELETE FROM `files` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `id` = '$file'");
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
<button data-bs-toggle="modal" type="button" data-bs-target="#create-files" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create Files</button> 
<button type="button" class="dt-button buttons-print btn btn-primary mr-1" data-bs-toggle="modal" type="button" data-bs-target="#deleteallfiles"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete All Files</button>
</form>
<br>
<div id="create-files" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Add Files</h4>
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
                                                        <label for="recipient-name" class="control-label">File URL: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="We recommend sending the file in a Discord DM where it won't get deleted. Then copy link and put here. Make sure the link has the file extension at the end, .exe or whatever. If it doesn't, the download will not work."></i></label>
                                                        <input type="text" class="form-control" name="url" placeholder="Link to file">
                                                    </div>
													<div class="form-check">
                                                        <br>
													<input class="form-check-input" name="authed" type="checkbox" id="flexCheckChecked" checked>
													<label class="form-check-label" for="flexCheckChecked">
														Authenticated <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="If checked, KeyAuth will force user to be logged in to use."></i>
													</label>
													</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="addfile">Add</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    

<table id="kt_datatable_files" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Filename</th>
        <th>File ID</th>
        <th>Filesize</th>
        <th>Upload Date</th>
        <th>Authenticated</th>
        <th>Action</th>
        </tr>
    </thead>

    <tbody>
<?php
if ($_SESSION['app'])
{
    ($result = mysqli_query($link, "SELECT * FROM `files` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result))
        {
            if(!$row["uploaddate"] == NULL) { $time = date('Y/m/d H:i', $row["uploaddate"]); } else { echo "N/A"; }
            echo "<tr>";

            echo "  <td>" . $row["name"] . "</td>";

            echo "  <td>" . $row["id"] . "</td>";

            echo "  <td>" . $row["size"] . "</td>";

            echo "  <td>" . $time . "</td>";

            echo "  <td>" . (($row["authed"] ? 1 : 0) ? 'True' : 'False') . "</td>";

            echo '<td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
												</button>
												<div class="dropdown-menu"><form method="post">
												<button class="dropdown-item" name="editfile" value="' . $row['id'] . '">Edit</button>
                                                <button class="dropdown-item" name="deletefile" value="' . $row['id'] . '">Delete</button>
												<a class="dropdown-item" href="' . $row['url'] . '">Download</a>
												</div></td></tr></form>';

        }

    }

}

?>
 </tbody>

</table>


<div class="modal fade" tabindex="-1" id="deleteallfiles">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete All Files</h2>

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
                <p> Are you sure you want to delete all files? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="delfiles" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['addfile']))
{
	$authed = sanitize($_POST['authed']) == NULL ? 0 : 1;
	$resp = add($_POST['url'], $authed);
    switch ($resp)
    {
		case 'invalid':
			error("URL not valid!");
			break;
        case 'failure':
			error("Failed to add file!");
			break;
		case 'success':
			success("Successfully added file!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}

if (isset($_POST['delfiles']))
{
	$resp = deleteAll();
    switch ($resp)
    {
        case 'failure':
			error("Failed to delete all files!");
			break;
		case 'success':
			success("Successfully deleted all files!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}

if (isset($_POST['deletefile']))
{
	$resp = deleteSingular($_POST['deletefile']);
    switch ($resp)
    {
        case 'failure':
			error("Failed to delete all files!");
			break;
		case 'success':
			success("Successfully deleted all files!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}

if (isset($_POST['editfile']))
{
    $file = sanitize($_POST['editfile']);

    echo '<div id="edit-file" class="modal show" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Edit File</h4>
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
                                                        <label for="recipient-name" class="control-label">File URL: <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="We recommend sending the file in a Discord DM where it won\'t get deleted. Then copy link and put here. Make sure the link has the file extension at the end, .exe or whatever. If it doesn\'t, the download will not work."></i></label>
                                                        <input type="text" class="form-control" name="url" placeholder="Link to file">
                                                    </div>
													<div class="form-check">
                                                    <br>
													<input class="form-check-input" name="authed" type="checkbox" id="flexCheckChecked" checked>
													<label class="form-check-label" for="flexCheckChecked">
														Authenticated <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="If checked, KeyAuth will force user to be logged in to use."></i>
													</label>
													</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onClick="window.location.href=window.location.href" class="btn btn-secondary">Close</button>
                                                <button class="btn btn-danger" value="' . $file . '" name="savefile">Save</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>';
}

if (isset($_POST['savefile']))
{
    $fileid = sanitize($_POST['savefile']);
    $url = sanitize($_POST['url']);

    if (!filter_var($url, FILTER_VALIDATE_URL))
    {
        error("Invalid Url!");
        return;
    }

    $file = file_get_contents($url);

    $filesize = strlen($file);

    if ($filesize > 10000000 && $role == "tester")
    {
        error("Users with tester plan may only upload files up to 10MB. Paid plans may upload up to 50MB.");
        return;
    }
    else if ($filesize > 50000000)
    {
        error("File size limit is 50 MB.");
        return;
    }

    $fn = basename($url);
    $fs = formatBytes($filesize);

    $authed = sanitize($_POST['authed']) == NULL ? 0 : 1;

    mysqli_query($link, "UPDATE `files` SET `name` = '$fn',`size` = '$fs',`url` = '$url', `uploaddate` = '" . time() . "', `authed` = '$authed' WHERE `app` = '" . $_SESSION['app'] . "' AND `id` = '$fileid'");

    if (mysqli_affected_rows($link) != 0)
    {
        success("Successfully Updated File!");
        echo "<meta http-equiv='Refresh' Content='2;'>";
    }
    else
    {
        error("Failed to update file");
    }
}
?>
</div>
<!--end::Container-->
