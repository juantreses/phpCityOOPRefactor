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
                $this->configuration['db_pass'],
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

    /* Nicole works over here










    */


//     Alex works over here
    public function getTemporaryPrintWeekTask()
    {
        if ($this->temporaryPrintWeekTask === null) {
            $this->temporaryPrintWeekTask = new TemporaryPrintWeekTask($this->getDatabaseService());
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