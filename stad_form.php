<?php
require_once "lib/autoload.php";

$css = array( "style.css" );
$viewService->basicHead($css, "Formulier Stad");  ?>
<div class="container">
    <div class="row">

        <?php
        $cityLoader = $container->getCityLoader();
        $city = $cityLoader->getCityByID($id = $_GET['id']);

        $template = $viewService->loadTemplate("stad_form");
        print $viewService->replaceCities($city, $template);
        ?>

    </div>
</div>

</body>
</html>