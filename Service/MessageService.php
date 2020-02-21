<?php

class MessageService
{
    public function AddMessage( $msg, $type = "info" )
    {
        $_SESSION["$type"][] = $msg ;
    }
    }