<?php


class FormHandler
{

    private $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }


    /**
     * @param $userLogin
     * @return bool
     */

    public function checkIfUserIsInDatabase($userLogin)
    {
        //controle of gebruiker al bestaat
        $data = $this->databaseService->getData("SELECT * FROM users WHERE usr_login='" . $userLogin . "' ");
        $userIsInDatabase = ( count($data) > 0 )? true:false;
        return $userIsInDatabase;

//        $sql = "SELECT * FROM users WHERE usr_login='" . $userLogin . "' ";
//        $data = GetData($sql);


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

}