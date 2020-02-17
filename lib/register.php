<?php
$register_form = true;
require_once "autoload.php";

$formname = $_POST["formname"];
$tablename = $_POST["tablename"];
$pkey = $_POST["pkey"];

if ( $formname == "registration_form" AND $_POST['registerbutton'] == "Register" )
{
    $User = new User();
    // if the from and user data is valid
    if ($UserService->ValidatePostedUserData())
    {
        if ($UserService->RegisterUser($User))
        {
            header("Location:../steden.php");
        }
    }else
    {
        header("Location:../register.php");
    }

}
?>