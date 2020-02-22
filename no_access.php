<?php
$no_access = true;
require_once "lib/autoload.php";

$css = array( "style.css");
$viewService->basicHead($css, "Geen toegang");

?>

<div class="container">

        <?php
        print $viewService->loadTemplate("no_access");
        ?>

</div>

</body>
</html>