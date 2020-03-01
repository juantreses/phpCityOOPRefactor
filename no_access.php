<?php
$no_access = true;
require_once "lib/autoload.php";

$css = array( "style.css");
$viewService->basicHead($css, "Geen toegang");

print $viewService->loadTemplate("no_access");

