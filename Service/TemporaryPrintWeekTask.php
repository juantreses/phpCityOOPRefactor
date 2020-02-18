<?php


class TemporaryPrintWeekTask
{
    private $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;

    }

    public function printWeek($week, $year)
    {
        $tasklist = "";
        for( $day=1; $day <= 7; $day++ )
        {
            $d = strtotime($year . "W" . $week . $day);
            $sqldate = date("Y-m-d", $d);
            $data = $this->databaseService->getData( "SELECT taa_omschr FROM taak WHERE taa_datum = '".$sqldate."'" );

            $taken = array();
            foreach( $data as $row )
            {
                $taken[] = $row['taa_omschr'];
            }
            $takenlijst = "<ul><li>" . implode( "</li><li>" , $taken ) . "</li></ul>";

            $tableRow  = "<tr><td>". date("l", $d). "</td><td>". date("d/m/Y", $d). "</td><td>". $takenlijst . "</td></tr>";
            $tasklist .= $tableRow;
        }

        $link_vorige = "week.php?week=" . ($week == 1 ? 52 : $week - 1 ) . "&year=" . ($week == 1 ? $year - 1 : $year);
        $link_volgende = "week.php?week=" . ($week == 52 ? 1 : $week + 1 ) . "&year=" . ($week == 52 ? $year + 1 : $year);
        $tasklist .= "</table><a href=$link_vorige>Vorige Week</a>&nbsp<br><a href=$link_volgende>Volgende Week</a>&nbsp";
        $replacecontent['week'] = $tasklist;
        print ReplaceContentOneRow($replacecontent,LoadTemplate("week"));


    }

}