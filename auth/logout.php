<?php

session_start();

echo "<meta http-equiv='Refresh' Content='0; url=./auth/login.php'>"; 

session_destroy();

exit();

?>