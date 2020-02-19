<?php


class UploadService
{
    private $images;



    public function LoadUploadPage()
    {
        $this->images = glob( "img/*.{jpg,png,gif}", GLOB_BRACE );
        $this->printUploadForm();
        if(isset($this->images))
        {
            $this->printImages();
        }

    }

    private function printUploadForm()
    {
        print LoadTemplate("form_file_upload");
    }

    private function printImages()
    {
        $i =0;
        foreach( $this->images as $img )
        {

            $replaceData[$i]['img']= "'".$img."'" ;
            $i++;
        }
        print ReplaceContent($replaceData,LoadTemplate("file_upload_img"));
    }

    public function checkUploadForm()
    {
        global $MS;
        global $_application_folder;
        $target_dir = "../img/";                                                          //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
        $max_size = 5000000;                                                           //maximum grootte in bytes
        $allowed_extensions = [ "jpeg", "jpg", "png", "gif" ];
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

            if (!$this->CheckImage($f,$allowed_extensions,$max_size)
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


    private function CheckImage($f,$ext_allowed = array("png","jpg","jpeg"),$max_size = 8000000){
    // get the Mes. service
    global $MS;

    // Check the extensions
    $ext_allowed = array(
        "png",
        "jpg",
        "jpeg"
    );

    $filename = strtolower($f["name"]) ;
    $fileExplode = explode(".",$filename);
    $fileExt = end($fileExplode);
    if (! in_array($fileExt,$ext_allowed)){
        $MS->AddMessage( "U mag enkel jpg, jpeg of png bestanden toevoegen. ",'error' );
//            $_SESSION['error'] = " u mag enkel jpg, jpeg of png bestanden toevoegen, ";
        return false;
    }
if ($f["size"] > $max_size){
    $MS->AddMessage( "Een afbeelding mag maximum 8MB zijn ",'error' );
//            $_SESSION['error'] .= "een afbeelding mag maximum 8MB zijn.";
    return false;
}

// als er geen errors zijn zal True meegeven worden
return true;
}

}