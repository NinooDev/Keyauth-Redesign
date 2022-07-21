<?php
include '../includes/connection.php';
include '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE)
{   
    session_start();
}

if (!isset($_SESSION['username'])) {
         header("Location: ../auth/login.php");
        exit();
}


	        $username = $_SESSION['username'];
            ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));
            $row = mysqli_fetch_array($result);
            
            $banned = $row['banned'];
            $lastreset = $row['lastreset'];
if (!is_null($banned) || $_SESSION['logindate'] < $lastreset)
            {
				echo "<meta http-equiv='Refresh' Content='0; url=../auth/login.php'>";
				session_destroy();
				exit();
            }
        
            $role = $row['role'];
            $_SESSION['role'] = $role;
			

			
                            
?>
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
        ($result = mysqli_query($link, "SELECT * FROM `acclogs` WHERE `username` = '".$_SESSION['username']."'")) or die(mysqli_error($link));
        $rows = array();
        while ($r = mysqli_fetch_assoc($result))
        {
            $rows[] = $r;
        }

        foreach ($rows as $row)
        {
			?>

                                                    <tr>
													
													<td><script>document.write(convertTimestamp(<?php echo $row["date"]; ?>));</script></td>
													
                                                    <td><?php echo $row["ip"]; ?></td>
                                                    
                                                    <td><?php echo $row["useragent"]; ?></td>

                                                    </tr>

                                                <?php

                                            }
                                            

                                        ?>
                                        </tbody>


</table>
	
</div>
<!--end::Container-->
