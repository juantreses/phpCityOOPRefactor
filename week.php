<?php
require_once "lib/autoload.php";

$css = array( "style.css");
BasicHead($css);
$MS->ShowMessages();
?>
    <body>

    <div class="jumbotron text-center">
        <h1>Weekoverzicht</h1>
    </div>
    <?php
            PrintNavBar();

            $year = (isset($_GET['year'])) ? $_GET['year'] : date("Y");
            $week = (isset($_GET['week'])) ? $_GET['week'] : date("W");
            if ($week > 52)
            {
                $year++;
                $week = 1;
            }
            elseif ($week < 1)
            {
                $year--;
                $week = 52;
            }
            if( isset($_GET['week']) AND $week < 10 ) { $week = '0' . $week; }


            $temporaryPrintWeekTask = $container->getTemporaryPrintWeekTask();
            $temporaryPrintWeekTask->printWeek($week,$year);

            ?>

        </div>
    </div>
    </body>
</html>