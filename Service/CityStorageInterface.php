<?php


interface CityStorageInterface
{
    public function getCityByID($id);

    public function queryForCities();
}