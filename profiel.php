<?php
require_once "lib/autoload.php";
$userService = $container->getUserService();
$user = $userService->loadUserFromId($_SESSION['usr_id']);
if (!$user-> getPasfoto() != "" )
{
    $viewService->addMessage("U moet uw Pasfoto opladen!!!", "error");
}

$css = array( "style.css");
$viewService->basicHead($css, "Uw profiel");

//$viewService->printNavBar();

// Print the ProfielForm
$userService = $container->getUserService();
$userService->loadProfielPage();
?>

