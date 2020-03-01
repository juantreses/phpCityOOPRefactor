<?php
require_once "lib/autoload.php";

$css = array( "style.css");
$viewService->basicHead($css, "Weekoverzicht");
$viewService->renderWeek();
?>
    </div>
    </body>
</html>