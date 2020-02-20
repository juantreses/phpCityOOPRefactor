<?php
require_once "autoload.php";



if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" )
{
    $uploadService = $container->getUploadService();
    $uploadService->checkUploadForm();
}

