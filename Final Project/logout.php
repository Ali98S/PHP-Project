<?php
session_start();

include 'header.php';
$user = new Users();
$user->Logout();

header('Location: Login.php');
?>
