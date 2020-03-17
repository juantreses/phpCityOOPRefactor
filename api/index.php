<?php
require_once '../lib/autoload.php';

$apiService = $container->getAPIService();

$uriParts = explode("/", $_SERVER['REQUEST_URI']);

$count = count($uriParts);

$lastUriPart = $uriParts[$count-1];
$secondToLastUriPart = $uriParts[$count-2];

if ($count === 4 && $lastUriPart === 'taken') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo $apiService->read();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo $apiService->create();
    } else {
        http_response_code(404);
        return json_encode(array("message" => "Unvalid request method"));
    }
}

elseif ($count === 5 && $secondToLastUriPart === 'taken') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo $apiService->readOne($lastUriPart);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        echo $apiService->update($lastUriPart);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        echo $apiService->delete($lastUriPart);
    } else {
        http_response_code(404);
        return json_encode(array("message" => "Unvalid request method"));
    }
}