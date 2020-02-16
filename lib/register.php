<?php
$register_form = true;
require_once "autoload.php";

$formname = $_POST["formname"];
$tablename = $_POST["tablename"];
$pkey = $_POST["pkey"];

if ( $formname == "registration_form" AND $_POST['registerbutton'] == "Register" )
{

    $UserService = new UserService();
    $User = new User();
    $UserService->ValidatePostedUserData($User);
    $UserService->RegisterUser($User);
}
?>