<?php
require_once "lib/autoload.php";

$css = array( "style.css" );
BasicHead( $css );
?>
<body>

<div class="jumbotron text-center">
    <h1>Formulier Stad</h1>
</div>
<?php PrintNavBar(); ?>
<div class="container">
    <div class="row">

        <?php
        $container = new Container($connectionData);
        $views = new ViewService();

        $cityLoader = $container->getCityLoader();
        $city = $cityLoader->getCityByID($id = $_GET['id']);

        $template = $views->loadTemplate("stad_form");
        print ReplaceCities( $city, $template);
        ?>

    </div>
</div>

</body>
</html>