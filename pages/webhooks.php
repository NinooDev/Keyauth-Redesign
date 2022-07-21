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

function add($baseLink, $userAgent, $authed, $secret = null)
{
	global $link;
	$baseLink = sanitize($baseLink);
	$userAgent = sanitize($userAgent);
	$authed = sanitize($authed);
	
    $webid = generateRandomString();
	if(is_null($userAgent))
	$userAgent = "KeyAuth";
	mysqli_query($link, "INSERT INTO `webhooks` (`webid`, `baselink`, `useragent`, `app`, `authed`) VALUES ('$webid','$baseLink', '$userAgent', '" . ($secret ?? $_SESSION['app']) . "', '$authed')");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function deleteSingular($webhook, $secret = null)
{
	global $link;
	$webhook = sanitize($webhook);
	
	mysqli_query($link, "DELETE FROM `webhooks` WHERE `app` = '" . $_SESSION['app'] . "' AND `webid` = '$webhook'");
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
	
<button data-bs-toggle="modal" type="button" data-bs-target="#create-webhook" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create Webhook</button>
<br>


<div id="create-webhook" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Add Webhooks</h4>
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
                                                        <label for="recipient-name" class="control-label">Webhook Endpoint: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Webhooks can be used to send GET request with query paramaters from the KeyAuth server so you don't expose the link in your loader. The webhook function returns a string which is the response from the link. There is zero reason to send requests to links which need to be kept private in your loader without the webhok function. You run the risk of the link getting leaked."></i></label>
                                                        <input type="url" class="form-control" name="baselink" placeholder="The Link You Want KeyAuth to Send Request to" required>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">User-Agent: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="This is useless to most people, but if the link requires a certain user agent to keep bad actors out, specify that user agent here."></i></label>
                                                        <input type="text" class="form-control" placeholder="Default: KeyAuth" name="useragent">
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
                                                <button class="btn btn-danger" name="genwebhook">Add</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>
<br>
                                    <table id="kt_datatable_subs" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Webhook ID</th>
        <th>Webhook Endpoint</th>
        <th>User-Agent</th>
        <th>Authenticated</th>
        <th>Action</th>
        </tr>
    </thead>

    <tbody>
<?php
if ($_SESSION['app'])
{
    ($result = mysqli_query($link, "SELECT * FROM `webhooks` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result))
        {

            echo "<tr>";

            echo "  <td>" . $row["webid"] . "</td>";

            echo "  <td>" . $row["baselink"] . "</td>";

            echo "  <td>" . $row["useragent"] . "</td>";

            echo "  <td>" . (($row["authed"] ? 1 : 0) ? 'True' : 'False') . "</td>";

            // echo "  <td>". $row["status"]. "</td>";
            echo '<td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu"><form method="post">
                                                <button class="dropdown-item" name="deletewebhook" value="' . $row['webid'] . '">Delete</button>
												<button class="dropdown-item" name="editwebhook" value="' . $row['webid'] . '">Edit</button></div></td></tr></form>';

        }

    }

}

?>
                                        </tbody>

</table>
             
<?php
if (isset($_POST['genwebhook']))
{

    if ($_SESSION['role'] == "tester")
    {
        error("Free users can\'t create webhooks!");
    }
	else
	{
		$authed = sanitize($_POST['authed']) == NULL ? 0 : 1;
		$resp = add($_POST['baselink'], $_POST['useragent'], $authed);
		switch ($resp)
		{
			case 'failure':
				error("Failed to add webhook!");
				break;
			case 'success':
				success("Successfully added webhook!");
                echo "<meta http-equiv='Refresh' Content='2'>";
				break;
			default:
				error("Unhandled Error! Contact us if you need help");
				break;
		}
	}
}

if (isset($_POST['deletewebhook']))
{
	$resp = deleteSingular($_POST['deletewebhook']);
	switch ($resp)
	{
		case 'failure':
			error("Failed to delete webhook!");
			break;
		case 'success':
			success("Successfully deleted webhook!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}

if (isset($_POST['editwebhook']))
{
    $webhook = sanitize($_POST['editwebhook']);

    $result = mysqli_query($link, "SELECT * FROM `webhooks` WHERE `webid` = '$webhook' AND `app` = '" . $_SESSION['app'] . "'");
    if (mysqli_num_rows($result) == 0)
    {
        mysqli_close($link);
        error("Webhook not Found!");
        echo "<meta http-equiv='Refresh' Content='2'>";
        return;
    }

    $row = mysqli_fetch_array($result);

    $baselink = $row["baselink"];
    $useragent = $row["useragent"];

    echo '<div id="edit-webhook" class="modal show" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Edit Webhook</h4>
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
                                                        <label for="recipient-name" class="control-label">Webhook Endpoint:</label>
                                                        <input type="text" class="form-control" name="baselink" value="' . $baselink . '" required>
														<input type="hidden" name="webhook" value="' . $webhook . '">
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">User-Agent:</label>
                                                        <input type="text" class="form-control" name="useragent" value="' . $useragent . '" required>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onClick="window.location.href=window.location.href" class="btn btn-secondary">Close</button>
                                                <button class="btn btn-danger" name="savewebhook">Save</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
									</div>';
}

if (isset($_POST['savewebhook']))
{
    $webhook = sanitize($_POST['webhook']);

    $baselink = sanitize($_POST['baselink']);
    $useragent = sanitize($_POST['useragent']);

    mysqli_query($link, "UPDATE `webhooks` SET `baselink` = '$baselink',`useragent` = '$useragent' WHERE `webid` = '$webhook' AND `app` = '" . $_SESSION['app'] . "'");

    success("Successfully Updated Settings!");
    echo "<meta http-equiv='Refresh' Content='2'>";
}
?>

</div>
<!--end::Container-->
