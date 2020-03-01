<?php

require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css, "Leuke plekken in Europa"); ?>

<div class="container">
    <div class="row">

        <?php
        $cityService = $container->getCityService();
        $cities = $cityService->getCities();

        $template = $viewService->loadTemplate("steden");
        print $viewService->replaceCities($cities, $template);
        ?>

    </div>
</div>

</body>
</html>