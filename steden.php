<?php
ini_set("error_reporting", E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css);
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Leuke plekken in Europa</h1>
    <p>Tips voor citytrips voor vrolijke vakantiegangers!</p>
</div>

<?php $viewService->printNavBar(); ?>

<div class="container">
    <div class="row">

        <?php
        $cityLoader = $container->getCityLoader();
        $cities = $cityLoader->getCities();

        $template = $viewService->loadTemplate("steden");
        print $viewService->replaceCities($cities, $template);
        ?>

    </div>
</div>

</body>
</html>