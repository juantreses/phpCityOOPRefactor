<?php
require_once "autoload.php";
$target_dir = "../img/";                                                          //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
$max_size = 5000000;                                                           //maximum grootte in bytes
$allowed_extensions = [ "jpeg", "jpg", "png", "gif" ];       //toegelaten bestandsextensies

if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" ) //als het juiste form gesubmit werd
{
    $fileUploadNr = 0;
    foreach ( $_FILES as $f )
        {
            $upfile = array();
            $f['name'] = strtolower($f['name']);
            $upfile["name"]                            = basename($f["name"]);
            $upfile["tmp_name"]                    = $f["tmp_name"];
            $upfile["target_path_name"]       = $target_dir . $upfile["name"]; //samenstellen definitieve bestandsnaam (+pad)    //basename
            $upfile["extension"]                      = strtolower(pathinfo($upfile["name"], PATHINFO_EXTENSION));
            $upfile["getimagesize"]                = getimagesize($upfile["tmp_name"]);                 //getimagesize geeft false als het bestand geen afbeelding is
            $upfile["size"]                                = $f["size"];
            
            // If there is no file the loop wil be broken, otherwise the check's run and files are imported
            
            if ($upfile["name"] == "")
            {
                // Go and check the next photo in the next loop.
                $fileUploadNr++;
                continue;
            }

            if (!CheckImage($fileUploadNr)
            ){
                header("location:".$_application_folder."/file_upload.php");
                die;
            }
            else
            {
            //bestand verplaatsen naar definitieve locatie + naam
            if ( move_uploaded_file( $upfile["tmp_name"], $upfile["target_path_name"] ))
            {
                $MS->AddMessage( 'The file ' . $upfile["name"] . " has been uploaded as " . $upfile["target_path_name"]   );
//                echo "The file " . $upfile["name"] . " has been uploaded as " . $upfile["target_path_name"] . "<br>";
                $upLoad = true;

            }
            else
            {
                $MS->AddMessage( "Sorry, there was an unexpected error uploading file ". $upfile["name"]  ,'error' );
//                echo "Sorry, there was an unexpected error uploading file " . $upfile["name"] . "<br>";
                $upLoad = true;
            }
        }

    }
      // if there where no images selected there wil be a error message
    if(!$upLoad)$MS->AddMessage( "sorry, there where no images"  ,'error' );
        header("location:".$_application_folder."/file_upload.php");

}
    // If no files are found there is a error message loaded on the file_upload.php in the root folder.




    //overloop alle bestanden in $_FILES


function CheckImage($fileUploadNr){
    // get the Mes. service
    global $MS;

    // Check the extensions 
    $ext_allowed = array(
        "png",
        "jpg",
        "jpeg"
    );
    
    $filename = strtolower($_FILES[$fileUploadNr]["name"]) ;
    $fileExplode = explode(".",$filename);
    $fileExt = end($fileExplode);
    if (! in_array($fileExt,$ext_allowed)){
        $MS->AddMessage( "U mag enkel jpg, jpeg of png bestanden toevoegen. ",'error' );
//            $_SESSION['error'] = " u mag enkel jpg, jpeg of png bestanden toevoegen, ";
        return false;
    }
    if ($_FILES[$fileUploadNr]["size"] > 8000000){
        $MS->AddMessage( "Een afbeelding mag maximum 8MB zijn ",'error' );
//            $_SESSION['error'] .= "een afbeelding mag maximum 8MB zijn.";
        return false;
    }
    
    // als er geen errors zijn zal True meegeven worden
    return true;
}
?>