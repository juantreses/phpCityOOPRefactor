<?php
require __DIR__."\..\..\lib\pdo.php";
//require __DIR__."\..\..\lib\passwd.php";

use PHPUnit\Framework\TestCase;

class ModelUserTest extends TestCase
{
    protected $User;
    protected $UserService;
    protected $UserDataRow;

    protected function  setUp(): void
    {
        $this->User = new User();
        $this->UserService = new UserService();


    }


    public function testReturnsFullName()
    {

        $this->User->setVoornaam("alex");
        $this->User->setnaam("Van den Broeck");
        $this->assertEquals("alex",$this->User->getVoornaam());
        $this->assertEquals("Van den Broeck",$this->User->getNaam());

    }
    public function testLoadUser()
    {
        $sql = "SELECT * FROM users WHERE usr_login='alex.alex@gmail.com' ";
        $data = GetData($sql);
        $this->User->Load($data[0]);
        $checkVoornaam = $this->User->getVoornaam();
        $checkNaam = $this->User->getNaam();
        $this->assertEquals("alex",$checkVoornaam);
        $this->assertEquals("Van den Broeck",$checkNaam);

    }




}