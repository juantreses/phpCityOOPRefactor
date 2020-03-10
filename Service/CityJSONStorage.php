<?php


class CityJSONStorage implements CityStorageInterface
{
    private $filename;

    public function __construct($jsonFilePath)
    {
        $this->filename = $jsonFilePath;
    }

    /**
     * @return array
     */
    public function queryForCities()
    {
        $jsonContents = file_get_contents($this->filename);

        return json_decode($jsonContents, true);
    }

    /**
     * @param $id
     * @return array|null
     */
    public function getCityByID($id)
    {
        $cities = $this->queryForCities();

        foreach ($cities as $city) {

            if ($city['img_id'] == $id) {
                $cityArray[0] = $city;
                return $cityArray;
            }
        }

        return null;
    }
}