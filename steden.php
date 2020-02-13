<?php
ini_set("error_reporting", E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

require_once "lib/autoload.php";

$css = array( "style.css");
BasicHead( $css );

$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Leuke plekken in Europa</h1>
    <p>Tips voor citytrips voor vrolijke vakantiegangers!</p>
</div>

<?php PrintNavBar(); ?>

<div class="container">
    <div class="row">

        <?php
        $cityLoader = new CityLoader();
        $cities = $cityLoader->Load();

        $template = LoadTemplate("steden");
        print ReplaceCities( $cities, $template);
        ?>

    </div>
</div>

</body>
</html>