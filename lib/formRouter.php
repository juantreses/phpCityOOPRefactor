<?
// fromRouter.php
$formname = $_POST["formname"];
$tablename = $_POST["tablename"];
$pkey = $_POST["pkey"];

switch ( $formname )
{
    case "profiel_form":
        // Do the things for profile form
        break;

    case "upload_form":
        if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" )
        {
            $uploadService = $container->getUploadService();
            $uploadService->submitUploadForms();
        }
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

