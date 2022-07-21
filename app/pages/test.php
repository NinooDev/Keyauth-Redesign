
<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">

<table id="kt_datatable_blacklists" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
    <tr class="fw-bolder fs-6 text-gray-800 px-7">
            <th>Date</th>
            <th>IP Address</th>
            <th>User Agent</th>
        </tr>
    </thead>

    
    <tbody>
                                            <?php
		if($_SESSION['app']) {
        ($result = mysqli_query($link, "SELECT * FROM `keys` WHERE `genby` = '".$_SESSION['username']."'")) or die(mysqli_error($link));
        
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

                                                    <td><?php echo $row["genby"]; ?></td>
                                                    
                                                    <td><?php echo $row["expires"] / 86400 ?> Day(s)</td>
                                                    <td><?php echo $row["note"] ?? "N/A"; ?></td>
													<td><?php echo $row["usedby"]; ?></td>
                                                    <td><label class="<?php echo $badge; ?>"><?php echo $row['status']; ?></label></td>

                                            <form method="POST"><td><button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" name="deletekey" value="<?php echo $key; ?>">Delete</button>
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ban-key" onclick="bankey('<?php echo $key; ?>')">Ban</a>
                                                <button class="dropdown-item" name="unbankey" value="<?php echo $key; ?>">Unban</button>
                                                <div class="dropdown-divider"></div>
												<?php
                                                }

                                            }

                                        ?>
                                        </tbody>


</table>

<!--end::Datatable-->



</div>
<!--end::Container-->
