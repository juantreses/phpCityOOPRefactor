<?php
require_once "lib/autoload.php";

$downloadService = $container->getDownloadService();
$downloadService->printCSVHeader("taken" . date("Y_m_d_His"));
$downloadService->generateRows();
