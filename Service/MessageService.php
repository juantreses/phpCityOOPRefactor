<?php

class MessageService
{
    public function addMessage($msg, $type = "info" )
    {
        $_SESSION["$type"][] = $msg ;
    }
    }