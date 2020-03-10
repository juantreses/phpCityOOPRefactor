<?php


class CityPDOStorage implements CityStorageInterface
{

    private $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    /**
     * @return array
     */
    public function queryForCities()
    {
        $cityArray = $this->databaseService->getData('SELECT * FROM images');
        return $cityArray;
    }

    /**
     * @param $id
     * @return array|null
     */
    public function getCityByID($id)
    {
        $cityArray = $this->databaseService->getData("SELECT * FROM images WHERE img_id = ". $id);


        if (!$cityArray) {
            return null;
        }

        return $cityArray;
    }
}