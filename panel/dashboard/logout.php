<?php

session_start();

$url = $_SESSION["url"];
echo "<meta http-equiv='Refresh' Content='0; url=$url'>"; 
session_destroy();

exit();

?>