<?php
//require_once "./lib/autoload.php";

class DownloadService
{

    function PrintCSVHeader( $filename )
    {
        // CSV header
        header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");

        //session_cache_limiter("must-revalidate");

        header("Content-Type: application/csv-tab-delimited-table");
        header("Content-disposition: attachment; filename=".$filename.".csv");
    }


    function GenerateRows() {
        //veldnamenrij
        echo implode(";", array("ID", "Datum", "Taak")) . "\r\n" ;

        $sql = "SELECT * FROM taak" ;
        $data = GetData($sql);

        //rijen met data
        foreach( $data as $row )
        {
            echo implode(";", $row) . "\r\n" ;
        }
    }



}