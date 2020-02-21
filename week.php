<?php
require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css);
$MS->ShowMessages();
?>
    <body>
    <div class="jumbotron text-center">
        <h1>Weekoverzicht</h1>
    </div>

    <?php $viewService->printNavBar(); ?>

    <?php



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