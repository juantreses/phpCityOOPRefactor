<?php
require_once "lib/autoload.php";

$css = array( "style.css" );
$viewService->basicHead($css, "Formulier Stad");
?>
<div class="container">
    <div class="row">

        <?php
        $cityService = $container->getCityService();
        $city = $cityService->getCityByID($id = $_GET['id']);

        $userService = $container->getUserService();
        $user = $userService->loadUserFromId($_SESSION['usr_id']);

        if ($user->doesThisUserHaveAdminRigths()) {
            if ($user->getAdminPower() > 50) {
                $templateName = 'stad_form_admin';
            }
            else {
                $viewService->addMessage('You don\'t have enough power today, mister Admin', "error");
                $templateName = 'stad_form';
            }
            print $viewService->returnMessages();
            unset($_SESSION["error"]);
            unset($_SESSION["info"]);
        }

        $template = $viewService->loadTemplate($templateName);
        print $viewService->replaceCities($city, $template);
        ?>

    </div>
</div>

</body>
</html>