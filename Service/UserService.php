<?php


class UserService
{
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
            if($this->checkIfUserIsInDatabase($user->getLogin()))
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
     * @return bool
     */
    public function ValidatePostedUserData()
    {
        $pass = true;
        global $MS;

        // check if user already exists
        if ($this->checkIfUserIsInDatabase($_POST['usr_login']))
        {
            $MS->AddMessage( "Deze login bestaat al!","error" );
            $pass = false;
        }

        //check password
        if (strlen($_POST["usr_paswd"]) < 8){
            $MS->AddMessage( "Uw paswoord moet minimum 8 cijfers zijn!","error" );
            $pass = false;

        }

        //check email format
        if (!filter_var($_POST["usr_login"], FILTER_VALIDATE_EMAIL))
        {
            $MS->AddMessage( "Uw e-mail adres heeft een ongeldig formaat!","error" );
            $pass = false;
        }

        // If all is ok return true
        return $pass;
    }


    /**
     * @param User $user
     */
    public function RegisterUser(User $user)
    {
        $registrationSucces = false;
        global $tablename;
        global $_application_folder;
        global $MS;

        //wachtwoord coderen

        $password_encrypted = password_hash ( $_POST["usr_paswd"] , PASSWORD_DEFAULT );

        $sql = "INSERT INTO $tablename SET " .
            " usr_voornaam='" . htmlentities($_POST['usr_voornaam'], ENT_QUOTES) . "' , " .
            " usr_naam='" . htmlentities($_POST['usr_naam'], ENT_QUOTES) . "' , " .
            " usr_straat='" . htmlentities($_POST['usr_straat'], ENT_QUOTES) . "' , " .
            " usr_huisnr='" . htmlentities($_POST['usr_huisnr'], ENT_QUOTES) . "' , " .
            " usr_busnr='" . htmlentities($_POST['usr_busnr'], ENT_QUOTES) . "' , " .
            " usr_postcode='" . htmlentities($_POST['usr_postcode'], ENT_QUOTES) . "' , " .
            " usr_gemeente='" . htmlentities($_POST['usr_gemeente'], ENT_QUOTES) . "' , " .
            " usr_telefoon='" . htmlentities($_POST['usr_telefoon'], ENT_QUOTES) . "' , " .
            " usr_login='" . $_POST['usr_login'] . "' , " .
            " usr_paswd='" . $password_encrypted . "'  " ;

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



    /**
     * @param $userLogin
     * @return bool
     */

    public function checkIfUserIsInDatabase($userLogin)
    {
        //controle of gebruiker al bestaat
        $sql = "SELECT * FROM users WHERE usr_login='" . $userLogin . "' ";
        $data = GetData($sql);

        $userIsInDatabase = ( count($data) > 0 )? true:false;
        return $userIsInDatabase;

    }


}