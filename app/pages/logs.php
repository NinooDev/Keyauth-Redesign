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


function deleteAll($secret = null)
{
	global $link;
	
	mysqli_query($link, "DELETE FROM `logs` WHERE `logapp` = '" . ($secret ?? $_SESSION['app']) . "'");
    if (mysqli_affected_rows($link) > 0)
    {
		return 'success';
    }
    else
    {
		return 'failure';
    }
}
$_SESSION['role'] = $role;

    if ($role == "Reseller")
    {
        die('Resellers Not Allowed Here');
		
    }
	
?>
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
	
<form method="post">
<button type="button" data-bs-toggle="modal" type="button" data-bs-target="#del-logs" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete All Logs</button>
</form>


<div class="modal fade" tabindex="-1" id="del-logs">
   	<!--begin::Modal dialog-->
       <div class="modal-dialog modal-dialog-centered mw-900px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header">
                <h2 class="modal-title">Delete All Logs</h2>

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
                <p> Are you sure you want to delete all logs? </p>
                </label>
            </div>									
            <div class="modal-footer">
                <form method="post">
                <button  class="btn btn-light" data-bs-dismiss="modal">No</button>
                <button  name="dellogs" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
 <br>

 <table id="kt_datatable_logs" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Log Date</th>
        <th>Log Data</th>
        <th>Credential</th>
        <th>Device Name</th>
        </tr>
    </thead>

    <tbody>

<?php
if ($_SESSION['app'])
{
    ($result = mysqli_query($link, "SELECT * FROM `logs` WHERE `logapp` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result))
        {
?>

                                                    <tr>

													

													<td><script>document.write(convertTimestamp(<?php echo $row["logdate"]; ?>));</script></td>

                                                    <td><?php echo $row["logdata"]; ?></td>

													

                                                    <td><?php echo $row["credential"] ?? "N/A"; ?></td>

													

													<td><?php echo $row["pcuser"] ?? "N/A"; ?></td>

                                                    </tr></form>

												<?php
        }
    }
}
?>

                                        </tbody>


</table>

<?php
if (isset($_POST['dellogs']))
{
	$resp = deleteAll();
    switch ($resp)
    {
        case 'failure':
			error("Failed to delete all logs!");
			break;
		case 'success':
			success("Successfully deleted all logs!");
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
