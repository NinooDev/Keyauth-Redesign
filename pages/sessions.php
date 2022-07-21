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

function killAll($secret = null)
{
	global $link;
	
	mysqli_query($link, "DELETE FROM `sessions` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
function killSingular($id, $secret = null)
{
	global $link;
	$id = sanitize($id);
	
	mysqli_query($link, "DELETE FROM `sessions` WHERE `app` = '" . ($secret ?? $_SESSION['app']) . "' AND `id` = '$id'");
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
<button type="button" data-bs-toggle="modal" data-bs-target="#killallsessions" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Kill All Sessions</button>
</form>

<br>
                    
<table id="kt_datatable_subs" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>ID</th>
        <th>Credential</th>
        <th>Expires</th>
        <th>Authenticated</th>
        <th>Manage</th>
        </tr>
    </thead>

    <tbody>

<?php
if ($_SESSION['app'])
{
    ($result = mysqli_query($link, "SELECT * FROM `sessions` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result))
        {
            $cred = $row["credential"] ?? "N/A";
            if(!$row["expiry"] == NULL) { $time = date('Y/m/d H:i', $row["expiry"]); } else { echo "N/A"; }
            echo "<tr>";
            echo "  <td>" . $row["id"] . "</td>";
            echo "  <td>" . $cred . "</td>";
            echo "  <td>". $time ."</td>";
            echo "  <td>" . (($row['validated'] ? 1 : 0) ? 'true' : 'false') . "</td>";
            // echo "  <td>". $row["status"]. "</td>";
            echo '<td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                Manage

                                            </button>

                                            <div class="dropdown-menu"><form method="post">

                                                <button class="dropdown-item" name="kill" value="' . $row['id'] . '">Kill</button></div></td></tr></form>';
        }
    }
}

?>

</tbody>

</table>


<div class="modal fade" tabindex="-1" id="killallsessions">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Kill All Sessions</h2>

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
                <p> Are you sure you want to delete all sessions? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="killall" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['killall']))
{
	$resp = killAll();
    switch ($resp)
    {
        case 'failure':
			error("Failed to kill all sessions!");
			break;
		case 'success':
			success("Successfully killed all sessions!");
            echo "<meta http-equiv='Refresh' Content='2'>";
			break;
		default:
			error("Unhandled Error! Contact us if you need help");
			break;
	}
}
if (isset($_POST['kill']))
{
	$resp = killSingular($_POST['kill']);
    switch ($resp)
    {
        case 'failure':
			error("Failed to kill session!");
			break;
		case 'success':
			success("Successfully killed session!");
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
