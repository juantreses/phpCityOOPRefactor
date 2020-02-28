<?php
$form = true;
$register_form = true;
require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css, "Registratie");

print $viewService->loadTemplate("register");
?>

