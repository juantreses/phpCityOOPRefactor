<?php


class UploadService
{
    private $images;

    private $formHandler;

    private $viewService;


    public function __construct(FormHandler $formHandler, ViewService $viewService)
    {
        $this->formHandler = $formHandler;
        $this->viewService = $viewService;
    }

    /**
     * @return mixed
     */

    public function loadUploadPage()
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


    public function processUploadForm()
    {
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
                    $this->viewService->addMessage("Uw foto's zijn opgeslagen",'info');
                    // update the user in the database and reload the user
                }else
                {
                    $this->viewService->addMessage("Er liep iets mis","error");
                }
            }
        } else
        {
            // if there were no images selected
            $this->viewService->AddMessage("Er werden geen bestanden geselecteerd", 'error');
        }
        //return to the profile page
        header("location:".$_application_folder."/file_upload.php");
    }

    public function uploadFileModels($fileModels)
    {
        foreach ($fileModels as $file)
        {
            $tmpName = $file->getTmpName();
            $destination = $file-> getTargetLocation();
            if(!move_uploaded_file($tmpName,"../".$destination))
            {
             $this->viewService->AddMessage("Er liep iets mis met het uploaden van uw foto:".$destination);
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
                // set target location based on field
                case "pasfoto":
                    $newName = "pasfoto_" . $_SESSION['usr_id'] . "." . $fileModel-> getExtension();
                    $fileModel->setTargetLocation("img/",$newName,"usr_pasfoto ='".$newName."'");
                    break;
                case "eidvoor":
                    $newName = "eidvoor_" . $_SESSION['usr_id'] . "." . $fileModel-> getExtension();
                    $fileModel->setTargetLocation("img/",$newName,"usr_vz_eid ='".$newName."'");
                    break;
                case "eidachter":
                    $newName = "eidachter_" . $_SESSION['usr_id'] . "." . $fileModel-> getExtension();
                    $fileModel->setTargetLocation("img/",$newName,"usr_az_eid ='".$newName."'");
                    break;
                default:
                    $newName = $fileModel->getOriginalName();
                    $fileModel->setTargetLocation("img/",$newName,NULL);
                    break;
            }

        }
        return $files;
    }
}