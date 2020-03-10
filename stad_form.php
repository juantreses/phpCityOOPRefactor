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

        $templateName = $user->doesThisUserHaveAdminRigths() ?  'stad_form_admin' : 'stad_form';

        $template = $viewService->loadTemplate($templateName);
        print $viewService->replaceCities($city, $template);
        ?>

    </div>
</div>

</body>
</html>