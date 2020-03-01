<?php


class FormHandler
{

    private $databaseService;

    private $viewService;

    public function __construct(DatabaseService $databaseService, ViewService $viewService)
    {
        $this->databaseService = $databaseService;
        $this->viewService = $viewService;
    }


    /**
     * @param $userLogin
     * @return bool
     */

    public function checkIfUserIsInDatabase($userLogin)
    {
        //controle of gebruiker al bestaat
        $data = $this->databaseService->getData("SELECT * FROM users WHERE usr_login='" . $userLogin . "' ");
        $userIsInDatabase = (count($data) > 0) ? true : false;
        return $userIsInDatabase;
    }

    public function ValidatePostedUserData()
    {
        $pass = true;

        // check if user already exists
        if ($this->checkIfUserIsInDatabase($_POST['usr_login'])) {
            $this->viewService->addMessage("Deze login bestaat al!", "error");
            $pass = false;
        }

        //check password
        if (strlen($_POST["usr_paswd"]) < 8) {
            $this->viewService->addMessage("Uw paswoord moet minimum 8 cijfers zijn!", "error");
            $pass = false;

        }

        //check email format
        if (!filter_var($_POST["usr_login"], FILTER_VALIDATE_EMAIL)) {
            $this->viewService->addMessage("Uw e-mail adres heeft een ongeldig formaat!", "error");
            $pass = false;
        }

        // If all is ok return true
        return $pass;
    }


    public function RegisterUser()
    {
        // encrypt password

        $password_encrypted = password_hash($_POST["usr_paswd"], PASSWORD_DEFAULT);

        // insert into db

        $sql = "INSERT INTO users SET " .
            " usr_voornaam='" . htmlentities($_POST['usr_voornaam'], ENT_QUOTES) . "' , " .
            " usr_naam='" . htmlentities($_POST['usr_naam'], ENT_QUOTES) . "' , " .
            " usr_straat='" . htmlentities($_POST['usr_straat'], ENT_QUOTES) . "' , " .
            " usr_huisnr='" . htmlentities($_POST['usr_huisnr'], ENT_QUOTES) . "' , " .
            " usr_busnr='" . htmlentities($_POST['usr_busnr'], ENT_QUOTES) . "' , " .
            " usr_postcode='" . htmlentities($_POST['usr_postcode'], ENT_QUOTES) . "' , " .
            " usr_gemeente='" . htmlentities($_POST['usr_gemeente'], ENT_QUOTES) . "' , " .
            " usr_telefoon='" . htmlentities($_POST['usr_telefoon'], ENT_QUOTES) . "' , " .
            " usr_login='" . $_POST['usr_login'] . "' , " .
            " usr_paswd='" . $password_encrypted . "'  ";

        return $sql;

    }


    public function checkImagesFromFileModels($fileModelArray, $ext_allowed = array("png", "jpg", "jpeg"), $max_size = 8000000)
    {
        foreach ($fileModelArray as $fileModel)

        // Check the extensions

            if (!in_array($fileModel->getExtention(), $ext_allowed)) {
                $this->viewService->addMessage("U mag enkel jpg, jpeg of png bestanden toevoegen. ", 'error');
                //            $_SESSION['error'] = " u mag enkel jpg, jpeg of png bestanden toevoegen, ";
                return false;
            }
            if ($fileModel->getSize() > $max_size) {
                $this->viewService->addMessage("Een afbeelding mag maximum 8MB zijn ", 'error');
                //            $_SESSION['error'] .= "een afbeelding mag maximum 8MB zijn.";
                return false;
            }


        // als er geen errors zijn zal True meegeven worden
        return true;
    }

    public function SaveCity() {

        global $_application_folder;

        $tablename = $_POST["tablename"];
        $formname = $_POST["formname"];
        $afterinsert = $_POST["afterinsert"];
        $pkey = $_POST["pkey"];

        $sql_body = array();

        //key-value pairs samenstellen
        foreach( $_POST as $field => $value )
        {
            if ( in_array($field, array("tablename", "formname", "afterinsert", "pkey", "savebutton", $pkey))) continue;

            $sql_body[]  = " $field = '" . htmlentities($value, ENT_QUOTES) . "' " ;
        }

        if ( $_POST[$pkey] > 0 ) //update
        {
            $sql = "UPDATE $tablename SET " . implode( ", " , $sql_body ) . " WHERE $pkey=" . $_POST[$pkey];
            if ( $this->databaseService->executeSQL($sql) ) $new_url = $_application_folder  . "/$formname.php?id=" . $_POST[$pkey] . "&updateOK=true" ;
        }
        else //insert
        {
            $sql = "INSERT INTO $tablename SET " . implode( ", " , $sql_body );
            if ( $this->databaseService->executeSQL($sql) ) $new_url = $_application_folder . "/$afterinsert?insertOK=true" ;
        }

        //print $sql;
        header("Location: $new_url");

    }

    /**
     * @return array File
     */

    public function getFilesFromForm()
    {
        $filesModels = [];
        foreach ($_FILES as $formFieldName =>$file)
        {
            if($file['name'] == "")continue;
            $x = new File($file,$formFieldName);
            $filesModels[] = $x;
        }
        return $filesModels;
    }

}