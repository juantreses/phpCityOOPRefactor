<?php
require_once "lib/autoload.php";
if (!$_SESSION['usr']-> getPasfoto() != "" )
{
    $MS->addMessage("U moet uw Pasfoto opladen!!!", "error");
}

$css = array( "style.css");
$viewService->basicHead($css, "Uw profiel");

//$viewService->printNavBar();

// Print the ProfielForm
$userService = $container->getUserService();
$userService->loadProfielPage();
?>

