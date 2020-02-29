<?php


class UserService
{

    private $databaseService;

    private $formHandler;

    private $viewService;

    private $uploadService;

    public function __construct(DatabaseService $databaseService, FormHandler $formHandler,ViewService $viewService,UploadService $uploadService)
    {
        $this->databaseService = $databaseService;
        $this->formHandler = $formHandler;
        $this->viewService = $viewService;
        $this->uploadService = $uploadService;
    }

    /**
     * @param $userLogin
     * @param bool $fromRegistrateForm
     * @return bool
     * @throws Exception
     */

    public function checkLoginUser( $userLogin,$fromRegistrateForm = false)
    {
        $login_ok = false;
        //if you come from registration there are no checks
        if(!$fromRegistrateForm)
        {
            // Is the user in the database?
            if($this->formHandler->checkIfUserIsInDatabase($userLogin))
            {
                // Get the pw hash in the model
                $user = $this->loadUserFromId($this->getUserIdFromLogIn($userLogin));
                //check the pw from the form with the hash
                $login_ok = ($this->checkUserPassword($user))?true:false;
            }
        }

        if ( $login_ok || $fromRegistrateForm)
        {
            // assign th usr_id to a session and registration of the log-in  in the database
            $user = ($fromRegistrateForm)?$this->loadUserFromId($this->getUserIdFromLogIn($userLogin)):$user;
            $_SESSION['usr_id'] = $user->getId();
            $this->LogLoginUser();
            return true;
        }else
        {
            // if there was a problem,...
            return false;
        }

    }

    /**
     * @param $userLogIn
     * @return mixed
     */
    public function getUserIdFromLogIn($userLogIn)
    {
        $sql = "SELECT * FROM users WHERE usr_login='" .$userLogIn. "' ";
        $data = $this->databaseService->getData($sql);
        return $data[0]['usr_id'];
    }


    /**
     * @return bool
     * @throws Exception
     */
    public function CheckRegistrationSuccess()
    {
        $registrationSucces = true;
        global $MS;

        // register user in formhandler
        $sql = $this->formHandler->RegisterUser();

        // set data in model, check success and give msg

        if ($this->databaseService->executeSQL($sql) )
        {
            $MS->addMessage( "Bedankt voor uw registratie!","info" );

            if ( $this->checkLoginUser($_POST['usr_login'],true) )
            {
                $registrationSucces = true;
            }
            else
            {
                $MS->addMessage( "Sorry! Verkeerde er was een probleem bij het inloggen, probeer opnieuw!" ,"error");
                $registrationSucces = false;
            }
        }
        else
        {
            $MS->addMessage( "Sorry, er liep iets fout. Uw gegevens werden niet goed opgeslagen" ,"error") ;
            $registrationSucces = false;

        }
        return $registrationSucces;
    }

    /**
     * @throws Exception
     */
    public function LogLogoutUser()
    {
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "UPDATE log_user SET  log_out='".$now."' where log_session_id='".$session."'";
        $this->databaseService->executeSQL($sql);
    }

    /**
     * @throws Exception
     */

    public function LogLoginUser()
    {
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "INSERT INTO log_user SET log_usr_id=".$_SESSION['usr_id'].", log_session_id='".$session."', log_in= '".$now."'";
        $this->databaseService->executeSQL($sql);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function checkUserPassword(User $user)
    {
        $passwCheck = (password_verify($_POST["usr_paswd"],$user->getPaswd()))?true:false;
        return $passwCheck;
    }



    public function loadProfielPage()
    {
        //gebruikersgegevens ophalen uit databank
        $sql = "select * from users where usr_id=" . $_SESSION["usr_id"];
        $data = $this->databaseService->getData($sql);
        $contentProfielTable[0]["img_pasfoto"] = "";
        $contentProfielTable[0]["img_vz_eid"] = "";
        $contentProfielTable[0]["img_az_eid"] = "";

//            print "<table class='table table-striped table-bordered'>";


        $tableRow = "";
        foreach( $data[0] as $field => $value )
        {
            $notintable = false;

            //foto's afhandelen
            if ( $field == "usr_pasfoto" AND $value != "" ) { $contentProfielTable[0]["img_pasfoto"] = "<img class='thumbnail' src='img/$value'>"; $notintable = true; }
            if ( $field == "usr_vz_eid" AND $value != "" ) {  $contentProfielTable[0]["img_vz_eid"] = "<img class='thumbnail' src='img/$value'>"; $notintable = true; }
            if ( $field == "usr_az_eid" AND $value != "" ) { $contentProfielTable[0]["img_az_eid"] = "<img class='thumbnail' src='img/$value'>"; $notintable = true; }

            //password niet tonen
            if ( $field == "usr_paswd" ) $notintable = true;

            //alle andere velden weergeven
            if ( !$notintable )
            {
                $caption = str_replace("usr_", "", $field);
                $caption = strtoupper(substr($caption,0,1)) . substr($caption,1);
                $tableRow .= "<tr><td>$caption</td><td>$value</td></tr>";

            }
        }
        $contentProfielTable[0]["table_row"]= $tableRow;
        // replace the the fields in the template whit the data
        print $this->viewService->replaceContentOneRow($contentProfielTable[0],$this->viewService->loadTemplate("profiel"));

    }

    public function procesProfileForm()
    {
        global $MS;
        global $_application_folder;
        $files = $this->formHandler->getFilesFromForm();
        // if there are files submitted
        if($files)
        {
            // check the images
            if($this->formHandler->checkImagesFromFileModels($files))
            {
                //Get the file destination and sql statement for inserting the db
                $files = $this->uploadService->setFileDestination($files);
                // Upload the files
                if($this->uploadService->uploadFileModels($files))
                {
                    // update the user in the database and reload the user
                    if($this->updateImagesToDatabase($files))
                    {
                        $MS->addMessage("uw profiel werd aangepast","info");
                    }else{
                        $MS->addMessage("Er is een probleem met het updaten van uw userprofiel","error");
                    }
                }
            }
        }else
        {
            // if there where no images selected
            $MS->addMessage("Er Werden Geen Bestanden geselecteerd", 'error');

        }
            //return to the profile page
            header("location:".$_application_folder."/profiel.php");
    }

    public function processRegisterForm()
    {
        // if the form and user data is valid

        if ($this->formHandler->ValidatePostedUserData())
        {
            if ($this->CheckRegistrationSuccess())
            {
                header("Location:../steden.php");
            }
        }else
        {
            header("Location:../register.php");

        }

    }

    public function processLoginForm()
    {
        global $MS;
        global $_application_folder;
        if ( $this->checkLoginUser($_POST['usr_login']) )
        {
            $user = $this->loadUserFromId($_SESSION['usr_id']);
            $MS->addMessage( "Welkom, " . $user->getVoornaam() . "!" );
            header("Location: " . $_application_folder . "/steden.php");
        }
        else
        {
            $MS->addMessage( "Sorry! Verkeerde login of wachtwoord!", "error" );
            header("Location: " . $_application_folder . "/login.php");
        }
    }

    public function updateImagesToDatabase($files)
    {
        foreach ($files as $fileModel)
        {
            $sqlImages[] = $fileModel->getSqlField();
        }
        $sql = "update users SET " . implode("," , $sqlImages) . " where usr_id=".$_SESSION['usr_id'];

        if($this->databaseService->executeSQL($sql))
        {
            return true;
        }else
        {
            return false;
        }

    }
    public function loadUserFromId($id)
    {
        $user = new User();
        $sql = "SELECT * FROM users WHERE usr_id='".$id. "' ";
        $data = $this->databaseService->getData($sql);
        $user->load($data[0]);
        return $user;

    }

    public function loadUserWithLoginData($id)
    {
        $user = $this->loadUserFromId($id);
        $sql = "SELECT * FROM log_user WHERE log_usr_id=" . $_SESSION['usr_id']. " ORDER BY log_in" ;
        $data = $this->databaseService->getData($sql);
        $user->setLogInData($data);

        return $user;
    }

}