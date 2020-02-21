<?php
$login_form = true;
require_once "autoload.php";


$formname = $_POST["formname"];
$buttonvalue = $_POST['loginbutton'];

if ( $formname == "login_form" AND $buttonvalue == "Log in" )
{

    $User = new User();
    $User->setLogin($_POST['usr_login']);

    if ( $UserService->checkLoginUser($User) )
    {
        $MS->addMessage( "Welkom, " . $User->getVoornaam() . "!" );
        header("Location: " . $_application_folder . "/steden.php");
    }
    else
    {
        $MS->addMessage( "Sorry! Verkeerde login of wachtwoord!", "error" );
        header("Location: " . $_application_folder . "/login.php");
    }
}
else
{
    $MS->addMessage( "Foute formname of buttonvalue", "error" );
}
?>