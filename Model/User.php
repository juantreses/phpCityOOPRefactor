<?php
class User
{
    private $id;
    private $voornaam;
    private $naam;
    private $login;
    private $paswd;
    private $straat;
    private $huisnr;
    private $busnr;
    private $postcode;
    private $gemeente;
    private $telefoon;
    private $pasfoto;
    private $vz_eid;
    private $az_eid;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getVoornaam()
    {
        return $this->voornaam;
    }

    /**
     * @param mixed $voornaam
     */
    public function setVoornaam($voornaam)
    {
        $this->voornaam = $voornaam;
    }

    /**
     * @return mixed
     */
    public function getNaam()
    {
        return $this->naam;
    }

    /**
     * @param mixed $naam
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPaswd()
    {
        return $this->paswd;
    }

    /**
     * @param mixed $paswd
     */
    public function setPaswd($paswd)
    {
        $this->paswd = $paswd;
    }

    /**
     * @return mixed
     */
    public function getStraat()
    {
        return $this->straat;
    }

    /**
     * @param mixed $straat
     */
    public function setStraat($straat)
    {
        $this->straat = $straat;
    }

    /**
     * @return mixed
     */
    public function getHuisnr()
    {
        return $this->huisnr;
    }

    /**
     * @param mixed $huisnr
     */
    public function setHuisnr($huisnr)
    {
        $this->huisnr = $huisnr;
    }

    /**
     * @return mixed
     */
    public function getBusnr()
    {
        return $this->busnr;
    }

    /**
     * @param mixed $busnr
     */
    public function setBusnr($busnr)
    {
        $this->busnr = $busnr;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * @return mixed
     */
    public function getGemeente()
    {
        return $this->gemeente;
    }

    /**
     * @param mixed $gemeente
     */
    public function setGemeente($gemeente)
    {
        $this->gemeente = $gemeente;
    }

    /**
     * @return mixed
     */
    public function getTelefoon()
    {
        return $this->telefoon;
    }

    /**
     * @param mixed $telefoon
     */
    public function setTelefoon($telefoon)
    {
        $this->telefoon = $telefoon;
    }

    /**
     * @return mixed
     */
    public function getPasfoto()
    {
        return $this->pasfoto;
    }

    /**
     * @param mixed $pasfoto
     */
    public function setPasfoto($pasfoto)
    {
        $this->pasfoto = $pasfoto;
    }

    /**
     * @return mixed
     */
    public function getVzEid()
    {
        return $this->vz_eid;
    }

    /**
     * @param mixed $vz_eid
     */
    public function setVzEid($vz_eid)
    {
        $this->vz_eid = $vz_eid;
    }

    /**
     * @return mixed
     */
    public function getAzEid()
    {
        return $this->az_eid;
    }

    /**
     * @param mixed $az_eid
     */
    public function setAzEid($az_eid)
    {
        $this->az_eid = $az_eid;
    }

    public function CheckLogin()
    {
        //gebruiker opzoeken ahv zijn login (e-mail)
        $sql = "SELECT * FROM users WHERE usr_login='" . $this->login . "' ";
        $data = GetData($sql);
        if ( count($data) == 1 )
        {
            $row = $data[0];
            //password controleren
            if ( password_verify( $this->paswd, $row['usr_paswd'] ) ) $login_ok = true;
        }

        if ( $login_ok )
        {
            session_start();
            $this->Load($row);
            $_SESSION['usr'] = $this;
            $this->LogLoginUser();
            return true;
        }

        return false;
    }

    private function Load( $row )
    {
        $this->id = $row['usr_id'];
        $this->voornaam = $row['usr_voornaam'];
        $this->naam = $row['usr_naam'];
        $this->login = $row['usr_login'];
        $this->paswd = $row['usr_paswd'];
        $this->straat = $row['usr_straat'];
        $this->huisnr = $row['usr_huisnr'];
        $this->busnr = $row['usr_busnr'];
        $this->postcode = $row['usr_postcode'];
        $this->gemeente = $row['usr_gemeente'];
        $this->telefoon = $row['usr_telefoon'];
        $this->pasfoto = $row['usr_pasfoto'];
        $this->vz_eid = $row['usr_vz_eid'];
        $this->az_eid = $row['usr_az_eid'];
    }

    public function LogLoginUser()
    {
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "INSERT INTO log_user SET log_usr_id=".$this->id.", log_session_id='".$session."', log_in= '".$now."'";
        ExecuteSQL($sql);
    }

    public function LogLogoutUser()
    {
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "UPDATE log_user SET  log_out='".$now."' where log_session_id='".$session."'";
        ExecuteSQL($sql);
    }

    public function CheckIfUserExistsAlready()
    {
        //controle of gebruiker al bestaat
        $sql = "SELECT * FROM users WHERE usr_login='" . $_POST['usr_login'] . "' ";
        $data = GetData($sql);
        if ( count($data) > 0 ) die("Deze gebruiker bestaat reeds! Gelieve een andere login te gebruiken.");
    }

    public function ValidatePostedUserData()
    {
        $this->CheckIfUserExistsAlready();

        //controle wachtwoord minimaal 8 tekens
        if ( strlen($_POST["usr_paswd"]) < 8 ) die("Uw wachtwoord moet minstens 8 tekens bevatten!");

        //controle geldig e-mailadres
        if (!filter_var($_POST["usr_login"], FILTER_VALIDATE_EMAIL)) die("Ongeldig email formaat voor login");
    }

    public function RegisterUser()
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

            $this->setLogin($_POST['usr_login']);
            $this->setPaswd($_POST['usr_paswd']);

            if ( $this->CheckLogin() )
            {
                header("Location: " . $_application_folder . "/steden.php");
            }
            else
            {
                $MS->AddMessage( "Sorry! Verkeerde login of wachtwoord na registratie!", "error" );
                header("Location: " . $_application_folder . "/login.php");
            }
        }
        else
        {
            $MS->AddMessage( "Sorry, er liep iets fout. Uw gegevens werden niet goed opgeslagen", "error" ) ;
        }
    }
}