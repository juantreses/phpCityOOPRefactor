<?php

use PHPUnit\Framework\TestCase;


class ModelUserTest extends TestCase
{
    protected $User;

    protected function  setUp(): void
    {
        $this->User = new User();
    }
    protected function tearDown(): void
    {

    }

    public function testReturnsFullName()
    {
//        require "../../Model/User.php";

        $this->User->setVoornaam("alex");
        $this->User->setnaam("Van den Broeck");
        $this->assertEquals("alex",$this->User->getVoornaam());
        $this->assertEquals("Van den Broeck",$this->User->getNaam());


    }

    /**
     * @depends testReturnsFullName (this let the next class use  the testReturnsFullName class
     */



}