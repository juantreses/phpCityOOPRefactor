<?php

use PHPUnit\Framework\TestCase;
require '../testFunctions.php';

class FunctionTest extends  TestCase
{
    public function testAddReturnsTheCorrectSum()
    {

        $this->assertEquals(4,add(2,2));
        $this->assertEquals(5,add(3,2));

    }

    public function testAddDoesNotReturnTheIncorrectResult()
    {
        $this->assertNotEquals(2,add(2,2));
    }

}