<?php
require_once "autoload.php";

if ( isset($_POST["submit"]) == "Opladen" )
{

    $target_dir = "../img/";                                                          //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
    $max_size = 5000000;                                                           //maximum grootte in bytes

    $images = array();


    //pasfoto, eid_voorzijde en eid_achterzijde overlopen
    foreach ( $_FILES as $inputname => $fileobject )   //overloop alle bestanden in $_FILES
    {
        //if there is no file to check continue
        if($fileobject["name"] == "") continue;
        $fileobject["name"] = strtolower($fileobject["name"]);
        $tmp_name = $fileobject["tmp_name"];
        $originele_naam = $fileobject["name"];
        $size = $fileobject["size"];
        $extensie = pathinfo($originele_naam, PATHINFO_EXTENSION);

        $target = "";



        if (CheckImage($fileobject,array("jpg","jpeg","png","gif"),5000000) )
        {
            switch ( $inputname )
            {
                case "pasfoto":
                    $target = "pasfoto_" . $_SESSION['usr']->getId() . "." . $extensie;
                    $images[] = "usr_pasfoto='" . $target . "'";
                    break;
                case "eidvoor":
                    $target = "eidvoor_" . $_SESSION['usr']->getId() . "." . $extensie;
                    $images[] = "usr_vz_eid='" . $target . "'";
                    break;
                case "eidachter":
                    $target = "eidachter_" . $_SESSION['usr']->getId() . "." . $extensie;
                    $images[] = "usr_az_eid='" . $target . "'";
                    break;
            }
            $target = $target_dir . $target;

            //bestand verplaatsen naar definitieve locatie
//            print "Moving " . $inputname . " to " . $target . "<br>";

            if ( move_uploaded_file( $tmp_name, $target))
            {
                $MS->AddMessage("Bestand $originele_naam opgeladen");
//                print "Bestand $originele_naam opgeladen<br>";
                $sql = "update users SET " . implode("," , $images) . " where usr_id=".$_SESSION['usr']->getId();
                ExecuteSQL($sql);


            }
            else $MS->AddMessage("Sorry, there was an unexpected error uploading file " . $originele_naam );
        }
        header("location:".$_application_folder."/profiel.php");
    }



}
