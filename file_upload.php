<?php
require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css, "Formulier File Upload");
?>

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