<?php


class Container
{
    private $configuration;

    private $pdo;

    private $cityLoader;

    private $downloadService;

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

    /**
     * @param string $sql
     * @return array
     */
    public function getData(string $sql)
    {
        $stm = $this->getPDO()->prepare($sql);
        $stm->execute();

        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * @param $sql
     * @return bool
     */
    function executeSQL(string $sql )
    {
        $stm = $this->getPDO()->prepare($sql);

        if ( $stm->execute() ) return true;
        else return false;
    }

    public function getCityLoader()
    {
        if ($this->cityLoader === null) {
            $this->cityLoader = new CityLoader($this->getPDO());
        }

        return $this->cityLoader;
    }

    public function getDownloadService()
    {
        if ($this->downloadService === null) {
            $this->downloadService = new DownloadService($this->getPDO());
        }

        return $this->downloadService;
    }

    /* Nicole works over here










    */


    /* Alex works over here








     */

    /* Jan works over here











    */
}