<?php


class Task
{
    private $id;
    private $datum;
    private $omschr;

    public function __construct($dataRow)
    {
        $this->datum = $dataRow['taa_datum'];
        $this->omschr = $dataRow['taa_omschr'];
        $this->id = $dataRow['taa_id'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * @param mixed $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }

    /**
     * @return mixed
     */
    public function getOmschr()
    {
        return $this->omschr;
    }

    /**
     * @param mixed $omschr
     */
    public function setOmschr($omschr)
    {
        $this->omschr = $omschr;
    }



}