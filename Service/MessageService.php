<?php

class MessageService
{
    private $viewService;

    public function __construct(ViewService $viewService)
    {
        $this->viewService = $viewService;
    }

    public function AddMessage( $msg, $type = "info" )
    {
        $_SESSION["$type"][] = $msg ;
    }

    public function ShowMessages()
    {
        if ( ! $_SESSION["head_printed"] ) $this->viewService->basicHead();

        //weergeven 2 soorten messages: errors en infos
        foreach( array("error", "info") as $type )
        {
            if ( key_exists("$type", $_SESSION) AND is_array($_SESSION["$type"]) AND count($_SESSION["$type"]) > 0 )
            {
                foreach( $_SESSION["$type"] as $message )
                {
                    $row = array( "message" => $message );
                    $templ = $this->viewService->loadTemplate("$type" . "s");
                    print $this->viewService->replaceContentOneRow( $row, $templ );
                }

                unset($_SESSION["$type"]);
            }
        }
    }

}