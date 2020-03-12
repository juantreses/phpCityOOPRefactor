<?php


class Container
{
    private $configuration;

    private $pdo;

    private $cityService;

    private $downloadService;

    private $databaseService;

    private $viewService;

    private $userService;

    private $formHandler;

    private $uploadService;

    private $messageService;

    private $taskLoader;

    private $cityStorage;

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

    public function getCityService()
    {
        if ($this->cityService === null) {
            $this->cityService = new CityService($this->getDatabaseService(), $this->getCityStorage());
        }

        return $this->cityService;
    }

    public function getDownloadService()
    {
        if ($this->downloadService === null) {
            $this->downloadService = new DownloadService($this->getTaskLoader());
        }

        return $this->downloadService;
    }

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

     public function getViewService()
     {
         if ($this->viewService === null) {
             $this->viewService = new ViewService($this->getDatabaseService(), $this->getTaskLoader());
         }

         return $this->viewService;
     }

    public function getTaskLoader()
    {
        if ($this->taskLoader === null) {
            $this->taskLoader = new TaskLoader($this->getDatabaseService());
        }

        return $this->taskLoader;
    }

    public function getCityStorage()
    {
        if ($this->cityStorage === null) {
            $this->cityStorage = new CityPDOStorage($this->getDatabaseService());
//            $this->cityStorage = new CityJSONStorage(__DIR__ . '/../resources/steden_images.json');
        }

        return $this->cityStorage;
    }
}