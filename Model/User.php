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
    private $log_in_data;

    /**
     * @return mixed
     */
    public function getLogInData()
    {
        return $this->log_in_data;
    }

    /**
     * @param mixed $log_in_data
     */
    public function setLogInData($log_in_data): void
    {
        $this->log_in_data = $log_in_data;
    }




    /**
     * @param $row
     */
    public function load($row )
    {
        $this->id = $row['usr_id'];
        $this->voornaam = $row['usr_voornaam'];
        $this->naam = $row['usr_naam'];
        $this->login = $row['usr_login'];
//        Better not saving the hash
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





}