<?php
require_once "lib/autoload.php";
$userService = $container->getUserService();
$user = $userService->loadUserFromId($_SESSION['usr_id']);
if (!$user-> getPasfoto() != "" )
{
    $viewService->addMessage("U moet uw pasfoto opladen!!!", "error");
}

$css = array( "style.css");
$viewService->basicHead($css, "Uw profiel");

// print the ProfileForm
$userService = $container->getUserService();
$userService->loadProfilePage();
?>

