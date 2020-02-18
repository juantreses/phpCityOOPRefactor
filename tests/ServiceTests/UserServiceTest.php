<?php
require __DIR__."\..\..\lib\pdo.php";
//require __DIR__."\..\..\lib\passwd.php";
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    protected $User;
    protected $UserService;

    protected function setUp(): void
    {
        $this->UserService = new UserService();
        $this->User = new User();


    }
    public function testLogInUser()
    {
        $this->User->setLogin("alex.alex@gmail.com");
        $this->User->setPaswd("123456789");
        $login = $this->UserService->CheckLogin($this->User);
        $this->assertEquals(true,$login);
    }

    public function testLoginUserFalseLogIn()
    {
        $this->User->setLogin("alexalex@gmail.com");
        $this->User->setPaswd("123456789");
        $login = $this->UserService->CheckLogin($this->User);
        $this->assertEquals(false,$login);
    }

    public function testLoginUserFalsePassw()
    {
        $this->User->setLogin("alex.alex@gmail.com");
        $this->User->setPaswd("156789");
        $login = $this->UserService->CheckLogin($this->User);
        $this->assertEquals(false,$login);
    }

}