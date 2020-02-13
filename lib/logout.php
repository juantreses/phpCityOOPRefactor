<?php
require_once "autoload.php";

session_start();
$User = new User();
$User->LogLogoutUser();

session_destroy();
unset($_SESSION);

session_start();
session_regenerate_id();
$MS->AddMessage( "U bent afgemeld!" );
header("Location: " . $_application_folder . "/login.php");
?>