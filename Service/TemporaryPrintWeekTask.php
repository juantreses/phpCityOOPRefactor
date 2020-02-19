<?php


class TemporaryPrintWeekTask
{
    private $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;

    }

    public function printWeekAndReturnNewDateForLink($week, $year)
    {
        // correction of the week //
        if( isset($_GET['week']) AND $week < 10 ) { $week = '0' . $week; }
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

        // getting 7 rows of data (day, date and tasks)
        for( $day=1; $day <= 7; $day++ )
        {
            $d = strtotime($year . "W" . $week . $day);
            $dataReplaceContent[$day - 1]['day'] = date("l", $d);
            $dataReplaceContent[$day - 1]['date'] = date("d/m/Y", $d);
            $data = $this->databaseService->getData( "SELECT taa_omschr FROM taak WHERE taa_datum = '".date("Y-m-d", $d)."'" );
            $dataReplaceContent[$day -1]['tasks']= ReplaceContent($data,LoadTemplate("week_tasks"));

        }
        // get this data on the week.php page end replace the new links to previous and next week.

        $dataReplaceOneRow['tableContent'] =  ReplaceContent($dataReplaceContent,LoadTemplate("week_table_row"));
        $dataReplaceOneRow['link_previous_week'] = "week.php?week=" . ($week == 1 ? 52 : $week - 1 ) . "&year=" . ($week == 1 ? $year - 1 : $year);
        $dataReplaceOneRow['link_next_week'] = "week.php?week=" . ($week == 1 ? 52 : $week + 1 ) . "&year=" . ($week == 1 ? $year + 1 : $year);
        print ReplaceContentOneRow($dataReplaceOneRow,LoadTemplate("week_table"));
        return $newDate= array($week,$year);


    }

}