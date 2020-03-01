<?php
//require_once "./lib/autoload.php";

class DownloadService
{
    private $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    public function printCSVHeader( $filename )
    {
        // CSV header
        header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: application/csv-tab-delimited-table");
        header("Content-disposition: attachment; filename=".$filename.".csv");
    }


    public function generateRows() {
        // field name row
        echo implode(";", array("ID", "Datum", "Taak")) . "\r\n";

        $data = $this->databaseService->getData('SELECT * FROM taak');

        //rows with data
        foreach( $data as $row )
        {
            echo implode(";", $row) . "\r\n" ;
        }
    }

}