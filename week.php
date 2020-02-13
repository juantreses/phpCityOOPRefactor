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
    <?php PrintNavBar(); ?>

    <div class="container">
        <div class="row">

            <?php
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
?>

    <table class="table">
        <tr>
            <th>Weekdag</th>
            <th>Datum</th>
            <th>Taken</th>
        </tr>
            <?php
            if( isset($_GET['week']) AND $week < 10 ) { $week = '0' . $week; }

            for( $day=1; $day <= 7; $day++ )
            {
                $d = strtotime($year . "W" . $week . $day);
                $sqldate = date("Y-m-d", $d);

                $sql = "SELECT taa_omschr FROM taak WHERE taa_datum = '".$sqldate."'" ;
                $data = GetData($sql);

                $taken = array();
                foreach( $data as $row )
                {
                    $taken[] = $row['taa_omschr'];
                }
                $takenlijst = "<ul><li>" . implode( "</li><li>" , $taken ) . "</li></ul>";

                echo "<tr>";
                echo "<td>" . date("l", $d). "</td>";
                echo "<td>" . date("d/m/Y", $d). "</td>";
                echo "<td>" . $takenlijst . "</td>";
                echo "</tr>" ;
            }

            echo "</table>";

            $link_vorige = "week.php?week=" . ($week == 1 ? 52 : $week - 1 ) . "&year=" . ($week == 1 ? $year - 1 : $year);
            $link_volgende = "week.php?week=" . ($week == 52 ? 1 : $week + 1 ) . "&year=" . ($week == 52 ? $year + 1 : $year);
            echo "<a href=$link_vorige>Vorige Week</a>&nbsp";
            echo "<a href=$link_volgende>Volgende Week</a>&nbsp";
            ?>

        </div>
    </div>
    </body>
</html>