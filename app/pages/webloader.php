<?php
include '../includes/connection.php';
include '../includes/functions.php';

$_SESSION['role'] = $role;

    if ($role == "Reseller")
    {
        die('Resellers Not Allowed Here');
		
    }

if ($_SESSION['role'] != "seller")
{
    exit();
}
?> 
<!--begin::Container-->


<div id="kt_content_container" class="container-xxl">
	
<button data-bs-toggle="modal" type="button" data-bs-target="#create-button" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create Button</button>

<br>
<br>

<table id="kt_datatable_blacklists" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
        <th>Button Text</th>
        <th>Button Value</th>
        <th>Action</th>
        </tr>
    </thead>

    
    <tbody>
<?php
if ($_SESSION['app'])
{
    ($result = mysqli_query($link, "SELECT * FROM `buttons` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result))
        {

            echo "<tr>";

            echo "  <td>" . $row["text"] . "</td>";

            echo "  <td>" . $row["value"] . "</td>";

            // echo "  <td>". $row["status"]. "</td>";
            echo '<td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu"><form method="post">
                                                <button class="dropdown-item" name="delButton" value="' . $row['value'] . '">Delete</button></div></td></tr></form>';

        }

    }

}

?>
                                        </tbody>


</table>

<?php
if (isset($_POST['addButton']))
{
	$text = sanitize($_POST['text']);
	$value = sanitize($_POST['value']);
	mysqli_query($link, "INSERT INTO `buttons` (`text`, `value`, `app`) VALUES ('$text','$value', '" . $_SESSION['app'] . "')");
	if(mysqli_affected_rows($link) > 0)
	{
		success("Successfully added button!");
        echo "<meta http-equiv='Refresh' Content='2'>";
	}
	else
	{
		error("Failed to add button! You can\'t have two buttons with the same value.");
	}
}

if (isset($_POST['delButton']))
{
	$value = sanitize($_POST['delButton']);
	mysqli_query($link, "DELETE FROM `buttons` WHERE `value` = '$value' AND `app` = '" . $_SESSION['app'] . "'");
	if(mysqli_affected_rows($link) > 0)
	{
		success("Successfully deleted button!");
        echo "<meta http-equiv='Refresh' Content='2'>";
	}
	else
	{
		error("Failed to delete button!");
	}
}

?>
	<div id="create-button" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
												<h4 class="modal-title">Add Button</h4>
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
                                                        <label for="recipient-name" class="control-label">Button Text: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="This is the text that will appear to your users after they connect to web loader"></i></label>
                                                        <input type="text" class="form-control" name="text" placeholder="e.g. Close Loader" required>
                                                    </div>
													<div class="form-group">
                                                        <label for="recipient-name" class="control-label">Button value: <i class="fas fa-question-circle fa-lg text-white-50" data-bs-toggle="tooltip" data-bs-placement="top" title="Button value must match the string you're using in the web loader. So if you're using the string 'close' in the web loader, you need to have the button value as 'close'."></i></label>
                                                        <input type="text" class="form-control" placeholder="e.g. close" name="value">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" name="addButton">Add</button>
												</form>
                                            </div>
                                        </div>
                                    </div>
                                    </div>

</div>
<!--end::Container-->
