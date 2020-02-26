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

            $User = new User();

            // if the form and user data is valid

//     $userService = $container->getUserService();
            $formHandler = $container->getFormHandler();


            if ($formHandler->ValidatePostedUserData())
            {
                if ($UserService->CheckRegistrationSuccess($User))
                {
                    header("Location:../steden.php");
                }
            }else
            {
                header("Location:../register.php");
            }
            header("Location:../register.php");
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

            $User = new User();
            $User->setLogin($_POST['usr_login']);

            if ( $UserService->checkLoginUser($User) )
            {
                $MS->AddMessage( "Welkom, " . $User->getVoornaam() . "!" );
                header("Location: " . $_application_folder . "/steden.php");
            }
            else
            {
                $MS->AddMessage( "Sorry! Verkeerde login of wachtwoord!", "error" );
                header("Location: " . $_application_folder . "/login.php");
            }
        }
        else
        {
            $MS->AddMessage( "Foute formname of buttonvalue", "error" );
        }
        break;
    default:
//        error message if no form is adressed
}

