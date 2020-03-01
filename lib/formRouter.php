<?php
$form = true;
require_once "autoload.php";

$formname = $_POST["formname"];

switch ( $formname )
{
    //Uses UserService for the logic, UserService uses databaseService , Formhandler and UploadService
    case "profiel_form":
        if ( isset($_POST["submit"]) == "Opladen" )
        {
            $userService = $container->getUserService();
            $userService->procesProfileForm();
        }
        break;

    case "file_upload":

        //uses UploadService for the logic, uploadService uses formhandler
        if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" )
        {
            $uploadService = $container->getUploadService();
            $uploadService->procesUploadForm();
        }
        header("location:".$_application_folder."/file_upload.php");
    break;

    case "registration_form":

        if ( $formname == "registration_form" AND $_POST['registerbutton'] == "Register" )
        {
            $userService = $container->getUserService();
            $userService->processRegisterForm();
        }
        break;

    case "stad_form":
        if ( $_POST["savebutton"] == "Save" ) {
            $formHandler = $container->getFormHandler();
            $formHandler->SaveCity();
        }
        break;

    case "login_form":
        if ($_POST['loginbutton'] == "Log in" )
        {
            $userService = $container->getUserService();
            $userService->processLoginForm();
        }
        else
        {
            $viewService->addMessage( "Foute formname of buttonvalue", "error" );
        }
        break;
    default:
//        error message if no form is addressed
}

