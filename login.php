<?php
$form = true;
$login_form = true;
require_once "lib/autoload.php";

//redirect naar homepage als de gebruiker al ingelogd is
if ( isset($_SESSION['usr']) )
{
    $viewService->addMessage( "U bent al ingelogd!" );
    header("Location: " . $_application_folder . "/steden.php");
    exit;
}

$css = array( "style.css");
$viewService->basicHead($css, "Login");

print $viewService->loadTemplate("login");
?>
