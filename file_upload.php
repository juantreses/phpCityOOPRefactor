<?php
require_once "lib/autoload.php";

$css = array( "style.css");
BasicHead( $css );
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Formulier File Upload</h1>
</div>

<?php PrintNavBar(); ?>

<div class="container">
    <div class="row">

        <?php
        $uploadService = $container->getUploadService();
        $uploadService->LoadUploadPage();

        ?>

    </div>
</div>

</body>
</html>