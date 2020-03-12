<?php
$form = true;
require_once "autoload.php";

$formname = $_POST["formname"];

switch ( $formname )
{
    //Uses UserService for the logic, UserService uses databaseService , Formhandler, ViewService and UploadService
    case "profiel_form":
        if ( isset($_POST["submit"]) == "Opladen" )
        {
            $userService = $container->getUserService();
            $userService->processProfileForm();
        }
        break;

    case "file_upload":

        //uses UploadService for the logic, uploadService uses formhandler and ViewService
        if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" )
        {
            $uploadService = $container->getUploadService();
            $uploadService->processUploadForm();
        }
        header("location:".$_application_folder."/file_upload.php");
    break;

    case "registration_form":

        //Uses UserService for the logic, UserService uses DatabaseService , Formhandler, ViewService and UploadService
        if ( $formname == "registration_form" AND $_POST['registerbutton'] == "Register" )
        {
            $userService = $container->getUserService();
            $userService->processRegisterForm();
        }
        break;

    case "stad_form":

        //Uses CityService for the logic, CityService uses DatabaseService
        if ( $_POST["savebutton"] == "Save" ) {
            $cityService = $container->getCityService();
            $cityService->SaveCity();
        }
        break;

    case "login_form":

        //Uses UserService for the logic, UserService uses DatabaseService , Formhandler, ViewService and UploadService
        if ($_POST['loginbutton'] == "Log in" )
        {
            var_dump($_POST);
            $userService = $container->getUserService();
            $userService->processLoginForm();
        }
        break;
    default:
        // error message if no form is addressed
        $viewService->addMessage( "Foute formname of buttonvalue", "error" );
}

