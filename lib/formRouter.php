<?php
require_once "autoload.php";

$formname = $_POST["formname"];
//$tablename = $_POST["tablename"];
//$pkey = $_POST["pkey"];


switch ( $formname )
{

    case "profiel_form":
        if ( isset($_POST["submit"]) == "Opladen" )
        {
            $userService = $container->getUserService();
            $userService->procesProfileForm();
        }

        break;

    case "file_upload":

        /*because fileUpload is not really connected to user or city,
         it does not use the UserService. If the FileUpload page were connected to the user,
         we would use the userService. Because of this the logic of processing the form happens here.
        And so no DI happens*/

        if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" )
        {
            $uploadService = $container->getUploadService();
            $formHandler = $container->getFormHandler();
            $files = $formHandler->getFilesFromForm();
            if($formHandler->checkImagesFromFileModels($files))
            {
                $files = $uploadService->setFileDestination($files);
                if($uploadService->uploadFileModels($files))
                {
                    $MS->AddMessage("uw Foto werd opgeladen","info");

                }else{
                    $MS->AddMessage("er liep iets mis met het opladen van de foto's","error");
                }
            }

        }
        header("location:".$_application_folder."/file_upload.php");
    break;

    case "registration_form":
        if($_POST['registerbutton'] == "Register" )
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

        }
        break;

    case "login_form":
        if ($buttonvalue == "Log in" )
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

