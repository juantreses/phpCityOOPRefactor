<?php


class Container
{
    private $configuration;

    private $pdo;

    private $cityLoader;

    private $downloadService;

    private $databaseService;

    private $viewService;
  
    private $temporaryPrintWeekTask;

    private $userService;

    private $formHandler;

    private $uploadService;


    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return PDO
     */
    public function getPDO()
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                $this->configuration['db_dsn'],
                $this->configuration['db_user'],
                $this->configuration['db_pass']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $this->pdo;
    }

    public function getDatabaseService()
    {
        if ($this->databaseService === null) {
            $this->databaseService = new databaseService($this->getPDO());
        }

        return $this->databaseService;


    }

    public function getCityLoader()
    {
        if ($this->cityLoader === null) {
            $this->cityLoader = new CityLoader($this->getDatabaseService());
        }

        return $this->cityLoader;
    }

    public function getDownloadService()
    {
        if ($this->downloadService === null) {
            $this->downloadService = new DownloadService($this->getDatabaseService());
        }

        return $this->downloadService;
    }

    /* Nicole works over here */

    public function getUserService()
    {
        if ($this->userService === null) {
            $this->userService = new UserService($this->getDatabaseService(), $this->getFormHandler(),$this->viewService,$this->getUploadService());
        }

        return $this->userService;
    }

     public function getFormHandler()
    {
        if ($this->formHandler === null) {
            $this->formHandler = new FormHandler($this->getDatabaseService(), $this->getViewService());
        }

        return $this->formHandler;
    }

    public function getUploadService()
    {
        if ($this->uploadService === null) {
            $this->uploadService = new UploadService($this->getFormHandler(), $this->getViewService());
        }

        return $this->uploadService;
    }


//     Alex works over here
    public function getTemporaryPrintWeekTask()
    {
        if ($this->temporaryPrintWeekTask === null) {
            $this->temporaryPrintWeekTask = new TemporaryPrintWeekTask($this->getDatabaseService(),$this->getViewService());
        }
        return $this->temporaryPrintWeekTask;
    }

//

    // Jan works over here

     public function getViewService()
        {
            if ($this->viewService === null) {
                $this->viewService = new ViewService($this->getDatabaseService());
            }

            return $this->viewService;
        }

}