<?php
require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css, "Formulier File Upload");

$uploadService = $container->getUploadService();

$uploadService->loadUploadPage();

?>

    </div>
</div>

</body>
</html>