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