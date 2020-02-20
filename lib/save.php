<?php
require_once "autoload.php";



if ( $_POST["savebutton"] == "Save" ) {
    $formHandler = $container->getFormHandler();
    $formHandler->SaveCity();
}
