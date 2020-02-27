<?php


class UploadService
{
    private $images;

    private $formHandler;

    private $viewService;

    private $messageService;

    public function __construct(FormHandler $formHandler, ViewService $viewService, MessageService $messageService)
    {
        $this->formHandler = $formHandler;
        $this->viewService = $viewService;
        $this->messageService = $messageService;
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
        print $this->viewService->loadTemplate("form_file_upload");
    }

    private function printImages()
    {
        $i =0;
        foreach( $this->images as $img )
        {

            $replaceData[$i]['img']= "'".$img."'" ;
            $i++;
        }
        print $this->viewService->replaceContent($replaceData,$this->viewService->loadTemplate("file_upload_img"));
    }


    public function procesUploadForm()
    {
        global $MS;
        global $_application_folder;
        $files = $this->formHandler->getFilesFromForm();

        // if there are files submitted
        if($files)
        {
            // check the images
            if($this->formHandler->checkImagesFromFileModels($files))
            {
                //Get the file destination and sql statement for inserting the db
                $files = $this->setFileDestination($files);
                // Upload the files
                if($this->uploadFileModels($files))
                {
                    $MS->addMessage("U Foto's zijn opgeslagen",'info');
                    // update the user in the database and reload the user

                }else
                {
                    $MS->addMessage("Er Liep iets mis","error");

                }
            }
        }else
        {
            // if there where no images selected
            $MS->AddMessage("Er Werden Geen Bestanden geselecteerd", 'error');

        }
        //return to the profile page
        header("location:".$_application_folder."/file_upload.php");

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
                    $newName = "pasfoto_" . $_SESSION['usr_id'] . "." . $fileModel-> getExtention();
                    $fileModel->setTargetLocation("img/",$newName,"usr_pasfoto ='".$newName."'");
                    break;
                case "eidvoor":
                    $newName = "eidvoor_" . $_SESSION['usr_id'] . "." . $fileModel-> getExtention();
                    $fileModel->setTargetLocation("img/",$newName,"usr_vz_eid ='".$newName."'");
                    break;
                case "eidachter":
                    $newName = "eidachter_" . $_SESSION['usr_id'] . "." . $fileModel-> getExtention();
                    $fileModel->setTargetLocation("img/",$newName,"usr_az_eid ='".$newName."'");
                    break;
                default:
                    $newName = $fileModel->getOriganalName();
                    $fileModel->setTargetLocation("img/",$newName,NULL);
                    break;
            }

        }
        return $files;
    }




}