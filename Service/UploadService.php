<?php


class UploadService
{
    private $images;

    private $formHandler;

    public function __construct(FormHandler $formHandler)
    {
        $this->formHandler = $formHandler;
    }


    public function LoadUploadPage()
    {
        $this->images = glob( "img/*.{jpg,png,gif}", GLOB_BRACE );
        $this->printUploadForm();
        if(isset($this->images))
        {
            $this->printImages();
        }

    }

    public  function LoadProfilePage()
    {

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

    public function submitUploadForms($profielCheck = false)
    {
        global $MS;
        global $_application_folder;
        $target_dir = "../img/";                                                          //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
        $max_size = 5000000;//maximum grootte in bytes
        $imagesUploadCheck = false;
        $images = array();


        //pasfoto, eid_voorzijde en eid_achterzijde overlopen
        foreach ( $_FILES as $inputname => $fileobject )   //overloop alle bestanden in $_FILES
        {

            //if there is no file to check continue
//            if($fileobject["name"] == "") continue;
            $fileobject["name"] = strtolower($fileobject["name"]);
            $tmp_name = $fileobject["tmp_name"];
            $originele_naam = $fileobject["name"];
            $size = $fileobject["size"];
            $extensie = pathinfo($originele_naam, PATHINFO_EXTENSION);

            $target = "";




            if ($this->formHandler->checkImagesFromFileModels($fileobject,array("jpg","jpeg","png","gif"),$max_size) )
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
                    case "uploadfoto":
                        $target =$fileobject["name"];
                        $target = $target_dir . $target;
                        $this->uploadFilesToDir($tmp_name,$target_dir);
                        header("location:".$_application_folder."/file_upload.php");
                        break;
                }
                $target = $target_dir . $target;

                //bestand verplaatsen naar definitieve locatie
//            print "Moving " . $inputname . " to " . $target . "<br>";

//                if ( move_uploaded_file( $tmp_name, $target))
//                {
//                    $imagesUploadCheck = true;
//                    $MS->AddMessage("Bestand $originele_naam opgeladen");
////                    header("location:".$_application_folder."/file_upload.php");
////                print "Bestand $originele_naam opgeladen<br>";
////                    $sql = "update users SET " . implode("," , $images) . " where usr_id=".$_SESSION['usr']->getId();
////                    ExecuteSQL($sql);
////                $userService = new UserService();
////                    $_SESSION['usr']->LoadUserInModelFromDatabase();
//
//
//                }
//                else $MS->AddMessage("Sorry, there was an unexpected error uploading file " . $originele_naam );
//            }else $MS->AddMessage("Sorry, there was an unexpected error uploading file " . $originele_naam );

        }


//        if(!$imagesUploadCheck)$MS->AddMessage("Sorry,there  where no images " ,"error");
//        header("location:".$_application_folder."/profiel.php");
//        header("location:".$_application_folder."/file_upload.php");




//
//        global $MS;
//        global $_application_folder;
//        $target_dir = "../img/";                     //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
//        $max_size = 5000000;                         //maximum grootte in bytes
//        $allowed_extensions = [ "jpeg", "jpg", "png", "gif" ];
//        $fileUploadNr = 0;
//        foreach ( $_FILES as $f )
//        {
//            $upfile = array();
//            $f['name'] = strtolower($f['name']);
//            $upfile["name"] = basename($f["name"]);
//            $upfile["tmp_name"] = $f["tmp_name"];
//            $upfile["target_path_name"] = $target_dir . $upfile["name"]; //samenstellen definitieve bestandsnaam (+pad)    //basename
//            $upfile["extension"] = strtolower(pathinfo($upfile["name"], PATHINFO_EXTENSION));
//            $upfile["getimagesize"] = getimagesize($upfile["tmp_name"]);                 //getimagesize geeft false als het bestand geen afbeelding is
//            $upfile["size"] = $f["size"];
//
//            // If there is no file the loop wil be broken, otherwise the check's run and files are imported
//
//            if ($upfile["name"] == "")
//            {
//                // Go and check the next photo in the next loop.
//                $fileUploadNr++;
//                continue;
//            }
//
//            if (!$this->formHandler->CheckImage($f,$allowed_extensions,$max_size)
//            ){
//                header("location:".$_application_folder."/file_upload.php");
//                die;
//            }
//            else
//            {
//                //bestand verplaatsen naar definitieve locatie + naam
//                if ( move_uploaded_file( $upfile["tmp_name"], $upfile["target_path_name"] ))
//                {
//                    $MS->AddMessage( 'The file ' . $upfile["name"] . " has been uploaded as " . $upfile["target_path_name"]   );
////                echo "The file " . $upfile["name"] . " has been uploaded as " . $upfile["target_path_name"] . "<br>";
//                    $upLoad = true;
//
//                }
//                else
//                {
//                    $MS->AddMessage( "Sorry, there was an unexpected error uploading file ". $upfile["name"]  ,'error' );
////                echo "Sorry, there was an unexpected error uploading file " . $upfile["name"] . "<br>";
//                    $upLoad = true;
//                }
//            }
//
//        }
//        // if there where no images selected there wil be a error message
//        if(!$upLoad)$MS->AddMessage( "sorry, there where no images"  ,'error' );
//        header("location:".$_application_folder."/file_upload.php");

    }


}


    public function uploadFileModels($fileModels)
    {
        global $MS;
        foreach ($fileModels as $file)
        {
            $tmpName = $file->getTmpName();
            $destination = $file-> getTargetLocation();
            if(!move_uploaded_file($tmpName,"../".$destination))
            {
             $MS->AddMessage("Er liep iets mis met het uploaden van uw Foto:".$destination);
                return false;
            }
        }
        return true;
    }

    public function setFileDestination($files)
    {
        foreach ($files as $fileModel)
        {
          $formField = $fileModel->getFormField();
            switch ( $formField )
            {
                case "pasfoto":
                    $newName = "pasfoto_" . $_SESSION['usr']->getId() . "." . $fileModel-> getExtention();
                    $fileModel->setTargetLocation("img/",$newName,"usr_pasfoto ='".$newName."'");
                    break;
                case "eidvoor":
                    $newName = "eidvoor_" . $_SESSION['usr']->getId() . "." . $fileModel-> getExtention();
                    $fileModel->setTargetLocation("img/",$newName,"usr_vz_eid ='".$newName."'");
                    break;
                case "eidachter":
                    $newName = "eidachter_" . $_SESSION['usr']->getId() . "." . $fileModel-> getExtention();
                    $fileModel->setTargetLocation("img/",$newName,"usr_az_eid ='".$newName."'");
                    break;
                case "uploadfoto":
                    $newName = $fileModel->getOriganalName();
                    $fileModel->setTargetLocation("img/",$newName,NULL);
                    break;
            }

        }
        return $files;
    }




}