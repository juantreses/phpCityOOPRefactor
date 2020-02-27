<?php
require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css, "Weekoverzicht");

// Get the year and week
$year = (isset($_GET['year'])) ? $_GET['year'] : date("Y");
$week = (isset($_GET['week'])) ? $_GET['week'] : date("W");

// print the week and return the new date(link updated in class)
$newdate = $viewService->printWeekAndReturnNewDateForLink($week,$year);
$week = $newdate[0];
$year = $newdate[1];
?>
    </div>
    </body>
</html>