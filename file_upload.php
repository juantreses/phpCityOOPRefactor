<?php
require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css);
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Formulier File Upload</h1>
</div>

<?php $viewService->printNavBar(); ?>

<div class="container">
    <div class="row">

        <?php

        $uploadService = $container->getUploadService();
//         $uploadService = new UploadService();
        $uploadService->LoadUploadPage();

        ?>

    </div>
</div>

</body>
</html>