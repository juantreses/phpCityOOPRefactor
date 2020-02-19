<?php


class Container
{
    private $configuration;

    private $pdo;

    private $cityLoader;

    private $downloadService;

    private $databaseService;

    private $temporaryPrintWeekTask;

    private $userService;

    private $formHandler;


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

//    /**
//     * @param string $sql
//     * @return array
//     */
//    public function getData(string $sql)
//    {
//        $stm = $this->getPDO()->prepare($sql);
//        $stm->execute();
//
//        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
//        return $rows;
//    }
//
//    /**
//     * @param $sql
//     * @return bool
//     */
//    function executeSQL(string $sql )
//    {
//        $stm = $this->getPDO()->prepare($sql);
//
//        if ( $stm->execute() ) return true;
//        else return false;
//    }

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
            $this->userService = new UserService($this->getDatabaseService(), $this->getFormHandler());
        }

        return $this->userService;
    }

     public function getFormHandler()
    {
        if ($this->formHandler === null) {
            $this->formHandler = new FormHandler();
        }

        return $this->formHandler;
    }


//     Alex works over here
    public function getTemporaryPrintWeekTask()
    {
        if ($this->temporaryPrintWeekTask === null) {
            $this->temporaryPrintWeekTask = new TemporaryPrintWeekTask($this->getDatabaseService());
        }
        return $this->temporaryPrintWeekTask;
    }


//

    /* Jan works over here











    */
}