<?php
require_once "autoload.php";

session_start();
//$UserService = new UserService();
$UserService->logLogoutUser();

session_destroy();
unset($_SESSION);

session_start();
session_regenerate_id();
$viewService->addMessage( "U bent afgemeld!" );
header("Location: " . $_application_folder . "/login.php");
?>