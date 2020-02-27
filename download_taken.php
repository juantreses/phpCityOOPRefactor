<?php
require_once "lib/autoload.php";

$container = new Container($connectionData);
$downloadService = $container->getDownloadService();
$downloadService->PrintCSVHeader("taken" . date("Y_m_d_His"));
$downloadService->GenerateRows();
