<?php


class UserService
{

    private $databaseService;

    private $formHandler;

    private $viewService;

    public function __construct(DatabaseService $databaseService, FormHandler $formHandler,ViewService $viewService)
    {
        $this->databaseService = $databaseService;
        $this->formHandler = $formHandler;
        $this->viewService = $viewService;
    }
    /**
     * @param User $user
     * @return bool
     */

    public function checkLoginUser(User $user,$fromRegistrateForm = false)
    {
        $login_ok = false;
        //if you come from registration there are no checks
        if(!$fromRegistrateForm)
        {
            // Is the user in the database?
            if($this->formHandler->checkIfUserIsInDatabase($user->getLogin()))
            {
                // Get the pw hash in the model
                $user->loadUserInModelFromDatabase();
                //check the pw from the form with the hash
                $login_ok = ($this->checkUserPassword($user))?true:false;
            }
        }
        
        // if you come from registration the user model is already loaded
        if ( $login_ok || $fromRegistrateForm)
        {
            // assign to superglobal and registration of the log-in  in the database
            $_SESSION['usr'] = $user;
            $this->LogLoginUser($user);
            return true;
        }else
        {
            // if there was a problem,...
            return false;
        }

    }


    /**
     * @param User $user
     */
    public function CheckRegistrationSuccess(User $user)
    {
        $registrationSucces = false;
        global $tablename;
        global $_application_folder;
        global $MS;

        // register user in formhandler
        $sql = $this->formHandler->RegisterUser();

        // set data in model, check success and give msg

        if (ExecuteSQL($sql) )
        {
            $MS->AddMessage( "Bedankt voor uw registratie!" );
            $user->setLogin($_POST['usr_login']);
            $user->setPaswd($_POST['usr_paswd']);
            $user->loadUserInModelFromDatabase();

            if ( $this->checkLoginUser($user,true) )
            {
                $registrationSucces = true;
            }
            else
            {
                $MS->AddMessage( "Sorry! Verkeerde er was een probleem bij het inloggen, probeer opnieuw!" ,"error");
                $registrationSucces = false;
            }
        }
        else
        {
            $MS->AddMessage( "Sorry, er liep iets fout. Uw gegevens werden niet goed opgeslagen" ,"error") ;
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
        ExecuteSQL($sql);
    }

    /**
     * @param User $user
     * @throws Exception
     */
    public function LogLoginUser(User $user)
    {
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "INSERT INTO log_user SET log_usr_id=".$user->getId().", log_session_id='".$session."', log_in= '".$now."'";
        ExecuteSQL($sql);
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
        $sql = "select * from users where usr_id=" . $_SESSION["usr"]->getId();
        $data = $this->databaseService->getData($sql);
        $img_az_eid = "";
        $img_vz_eid = "";
        $img_pasfoto = "";
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

}