<?php
class CityService
{
    private $databaseService;
    private $cityStorage;

    public function __construct(DatabaseService $databaseService, CityStorageInterface $cityStorage)
    {
        $this->databaseService = $databaseService;
        $this->cityStorage = $cityStorage;
    }

    /**
     * @return City[]
     */
    public function getCities()
    {
        $cityStorage = $this->cityStorage;
        $citiesData = $cityStorage->queryForCities();

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
    public function fetchCityDataByID($id)
    {
        $cityStorage = $this->cityStorage;
        $cityArray = $cityStorage->getCityByID($id);

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

    public function SaveCity() {

        global $_application_folder;

        $tablename = $_POST["tablename"];
        $formname = $_POST["formname"];
        $afterinsert = $_POST["afterinsert"];
        $pkey = $_POST["pkey"];

        $sql_body = array();

        // make key-value pairs
        foreach( $_POST as $field => $value )
        {
            if ( in_array($field, array("tablename", "formname", "afterinsert", "pkey", "savebutton", $pkey))) continue;

            $sql_body[]  = " $field = '" . htmlentities($value, ENT_QUOTES) . "' " ;
        }

        if ( $_POST[$pkey] > 0 ) //update
        {
            $sql = "UPDATE $tablename SET " . implode( ", " , $sql_body ) . " WHERE $pkey=" . $_POST[$pkey];
            if ( $this->databaseService->executeSQL($sql) ) $new_url = $_application_folder  . "/$formname.php?id=" . $_POST[$pkey] . "&updateOK=true" ;
        }
        else //insert
        {
            $sql = "INSERT INTO $tablename SET " . implode( ", " , $sql_body );
            if ( $this->databaseService->executeSQL($sql) ) $new_url = $_application_folder . "/$afterinsert?insertOK=true" ;
        }

        //print $sql;
        header("Location: $new_url");

    }


}