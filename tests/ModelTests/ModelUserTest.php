<?php

use PHPUnit\Framework\TestCase;
require "../../Model/User.php";
//require "../../lib/autoload.php";

class ModelUserTest extends TestCase
{
    public function testReturnsFullName()
    {
        $user = new User();
        $user->setVoornaam("alex");
        $user->setnaam("Van den Broeck");
        $this->assertEquals("alex",$user->getVoornaam());
        $this->assertEquals("Van den Broeck",$user->getNaam());

    }


}