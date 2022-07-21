<?php

	global $link;
    if (session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    if (!isset($_SESSION['username']))
    {
        header("Location: ../auth/login.php");
        exit();
    }

    $username = $_SESSION['username'];
    ($result = mysqli_query($link, "SELECT * FROM `accounts` WHERE `username` = '$username'")) or die(mysqli_error($link));
    $row = mysqli_fetch_array($result);

    $banned = $row['banned'];
    $lastreset = $row['lastreset'];
    if (!is_null($banned) || $_SESSION['logindate'] < $lastreset || mysqli_num_rows($result) === 0)
    {
        echo "<meta http-equiv='Refresh' Content='0; url= ../auth/login.php'>";
        session_destroy();
        exit();
    }
    $role = $row['role'];
    $_SESSION['role'] = $role;

    if ($role == "Reseller")
    {
        die('Resellers Not Allowed Here');
    }



?>