<?php
require_once '../lib/autoload.php';
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$apiService = $container->getAPIService();

$uriParts = explode("/", $_SERVER['REQUEST_URI']);

$count = count($uriParts);

$lastUriPart = $uriParts[$count-1];
$secondToLastUriPart = $uriParts[$count-2];

if ( $lastUriPart === 'taak') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo $apiService->read();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo $apiService->create();
    } else {
        http_response_code(418);
        print json_encode(array("message" => "Invalid request method"));
    }
}

elseif ( $secondToLastUriPart === 'taak') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        echo $apiService->readOne($lastUriPart);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        echo $apiService->update($lastUriPart);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        echo $apiService->delete($lastUriPart);
    } else {
        http_response_code(404);
        print json_encode(array("message" => "Invalid request method"));
    }
}