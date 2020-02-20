<?php
require_once "lib/autoload.php";
if (!$_SESSION['usr']-> getPasfoto() != "" )
{
    $MS->AddMessage("U moet uw Pasfoto opladen!!!", "error");
}

$css = array( "style.css");
$viewService->basicHead($css);
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Uw profiel</h1>
</div>
<?php

$viewService->printNavBar();

// Print the ProfielForm
$userService = $container->getUserService();
$userService->loadProfielPage();
?>

