<?php
require_once '../lib/autoload.php';

$apiService = $container->getAPIService();

$uriParts = explode("/", $_SERVER['REQUEST_URI']);

$count = count($uriParts);

$lastUriPart = $uriParts[$count-1];
$secondToLastUriPart = $uriParts[$count-2];

if ($count === 4 && $lastUriPart === 'taken') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        echo $apiService->read();
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo $apiService->create();
    }

}