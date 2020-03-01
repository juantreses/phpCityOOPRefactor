<?php
class CityLoader
{
    private $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    /**
     * @return City[]
     */
    public function getCities()
    {
        $citiesData = $this->queryForCities();

        $cities = array();
        foreach ($citiesData as $cityData) {
            $cities[] = $this->createCityFromData($cityData);
        }

        return $cities;
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

        $cities[] = $this->createCityFromData($cityArray[0]);

        return $cities;
    }

    /**
     * @param array $cityData
     * @return City
     */
    private function createCityFromData(array $cityData)
    {
        $city = new City();
        $city->setId($cityData['img_id']);
        $city->setFileName($cityData['img_filename']);
        $city->setTitle($cityData['img_title']);
        $city->setWidth($cityData['img_width']);
        $city->setHeight($cityData['img_height']);

        return $city;
    }

    /**
     * @return array
     */
    private function queryForCities()
    {
        $cityArray = $this->databaseService->getData('SELECT * FROM images');
        return $cityArray;
    }


}