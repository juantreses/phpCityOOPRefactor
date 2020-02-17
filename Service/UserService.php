<?php


class UserService
{
    public function CheckLogin(User $user)
    {
        $login_ok = false;
        //gebruiker opzoeken ahv zijn login (e-mail)
        $sql = "SELECT * FROM users WHERE usr_login='" .$user->getLogin() . "' ";
        $data = GetData($sql);
        if ( count($data) == 1 )
        {
            $row = $data[0];
            //password controleren
            if ( password_verify( $user->getPaswd(), $row['usr_paswd'] ) ) $login_ok = true;
        }

        if ( $login_ok )
        {
            $user->load($row);
            $_SESSION['usr'] = $user;
            $this->LogLoginUser($user);
            return true;
        }

        return false;
    }

    public function ReloadUser(User $user)
    {
        $sql = "SELECT * FROM users WHERE usr_login='" .$user->getLogin() . "' ";
        $data = GetData($sql);
        $user->Load($data[0]);
    }

    public function CheckIfUserExistsAlready()
    {
        //controle of gebruiker al bestaat
        $sql = "SELECT * FROM users WHERE usr_login='" . $_POST['usr_login'] . "' ";
        $data = GetData($sql);
        if ( count($data) > 0 ) die("Deze gebruiker bestaat reeds! Gelieve een andere login te gebruiken.");
    }


    public function ValidatePostedUserData(User $user)
    {
        $this->CheckIfUserExistsAlready();

        //controle wachtwoord minimaal 8 tekens
        if ( strlen($_POST["usr_paswd"]) < 8 ) die("Uw wachtwoord moet minstens 8 tekens bevatten!");

        //controle geldig e-mailadres
        if (!filter_var($_POST["usr_login"], FILTER_VALIDATE_EMAIL)) die("Ongeldig email formaat voor login");
    }


    public function RegisterUser(User $user)
    {
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

        if ( ExecuteSQL($sql) )
        {
            $MS->AddMessage( "Bedankt voor uw registratie!" );

            $user->setLogin($_POST['usr_login']);
            $user->setPaswd($_POST['usr_paswd']);

            if ( $this->CheckLogin($user) )
            {
                header("Location: " .__DIR__ . "/steden.php");
            }
            else
            {
                $MS->AddMessage( "Sorry! Verkeerde login of wachtwoord na registratie!" );
                header("Location: " . __DIR__ . "/login.php");
            }
        }
        else
        {
            $MS->AddMessage( "Sorry, er liep iets fout. Uw gegevens werden niet goed opgeslagen" ) ;
            header("Location: " . __DIR__ . "/login.php");
        }
    }

    public function LogLogoutUser()
    {
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "UPDATE log_user SET  log_out='".$now."' where log_session_id='".$session."'";
        ExecuteSQL($sql);
    }
    public function LogLoginUser(User $user)
    {
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "INSERT INTO log_user SET log_usr_id=".$user->getId().", log_session_id='".$session."', log_in= '".$now."'";
        ExecuteSQL($sql);
    }
}