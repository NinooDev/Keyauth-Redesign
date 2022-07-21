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
function deleteSingular($subscription)
{
	global $link;
	$subscription = sanitize($subscription);
	
    mysqli_query($link, "DELETE FROM `subscriptions` WHERE `app` = '".($secret ?? $_SESSION['app'])."' AND `name` = '$subscription'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function add($name, $level)
{
	global $link;
	$name = sanitize($name);
	$level = sanitize($level);
	
    mysqli_query($link, "INSERT INTO `subscriptions` (`name`, `level`, `app`) VALUES ('$name','$level', '".($secret ?? $_SESSION['app'])."')");
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

<button data-bs-toggle="modal" type="button" data-bs-target="#create-subscription" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create Subscription</button>
<br></br>
<div class="modal fade" tabindex="-1" id="create-subscription">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header d-flex align-items-center">

                    <h4 class="modal-title">Add Subscription</h4>

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

                            <label for="recipient-name" class="control-label">Subscription Name:</label>

                            <input type="text" class="form-control" name="subname" placeholder="Anything you want" required>

                        </div>

                        <div class="form-group">

                            <label for="recipient-name" class="control-label">Subscription Level: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="When the keys you create are redeemed, KeyAuth will assign the subscriptions with the same level as the key to the user being created. So basically, you can have several user ranks aka subscriptions."></i></label>

                            <input type="text" class="form-control" placeholder="License Key Level" name="level" required>

                        </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button class="btn btn-danger" name="addsub">Add</button>

                    </form>

                </div>

            </div>

        </div>
</div>


<table id="kt_datatable_subs" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Subscription Name</th>
        <th>License Level</th>
        <th>Action</th>
        </tr>
    </thead>

    <tbody>

<?php
if ($_SESSION['app'])
{
($result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0)
{
while ($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "  <td>" . $row["name"] . "</td>";
echo "  <td>" . $row["level"] . "</td>";
// echo "  <td>". $row["status"]. "</td>";
echo '<td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    Manage

                </button>

                <div class="dropdown-menu"><form method="post">

                    <button class="dropdown-item" name="deletesub" value="' . $row['name'] . '">Delete</button>

                    <button class="dropdown-item" name="editsub" value="' . $row['name'] . '">Edit</button></div></td></tr></form>';
}
}
}
?>

            </tbody>

</table>


<?php
if(isset($_POST['addsub']))
{
	$resp = add($_POST['subname'], $_POST['level']);
    switch ($resp)
    {
        case 'failure':
			error("Failed to create subscription!");
			break;
		case 'success':
			success("Successfully created subscription!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	} 
}
							
if (isset($_POST['deletesub']))
{
	$resp = deleteSingular($_POST['deletesub']);
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
if (isset($_POST['editsub']))
{
    $subscription = sanitize($_POST['editsub']);
    $result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `name` = '$subscription' AND `app` = '" . $_SESSION['app'] . "'");
    if (mysqli_num_rows($result) == 0)
    {
        mysqli_close($link);
        error("Subscription not Found!");
        echo "<meta http-equiv='Refresh' Content='2'>";
        return;
    }
    $row = mysqli_fetch_array($result);
    $level = $row["level"];
    echo '<div id="edit-webhook" class="modal show" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Edit Subscription</h4>

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

                                                        <label for="recipient-name" class="control-label">Subscription Level:</label>

                                                        <input type="text" class="form-control" name="level" value="' . $level . '" required>

														<input type="hidden" name="subscription" value="' . $subscription . '">

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" onClick="window.location.href=window.location.href" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                                <button class="btn btn-danger" name="savesub">Save</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>';
}
if (isset($_POST['savesub']))
{
    $subscription = sanitize($_POST['subscription']);
    $level = sanitize($_POST['level']);
    mysqli_query($link, "UPDATE `subscriptions` SET `level` = '$level' WHERE `name` = '$subscription' AND `app` = '" . $_SESSION['app'] . "'");
    success("Successfully Updated Settings!");
    echo "<meta http-equiv='Refresh' Content='2'>";
}
?>




</div>
<!--end::Container-->
