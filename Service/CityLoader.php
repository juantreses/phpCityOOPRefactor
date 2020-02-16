<?php
class CityLoader
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCities()
    {
        $citiesData = $this->queryForCities();

        $ships = array();
        foreach ($citiesData as $cityData) {
            $ships[] = $this->createCityFromData($cityData);
        }

        return $ships;
    }

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

    private function queryForCities()
    {
        $pdo = $this->getPDO();
        $statement = $pdo->prepare('SELECT * FROM images');
        $statement->execute();
        $cityArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $cityArray;
    }

    private function getPDO()
    {
        return $this->pdo;
    }
}