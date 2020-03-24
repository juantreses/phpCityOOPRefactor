<?php


class Task
{
    private $id;
    private $datum;
    private $omschr;
    private $status;
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }    /**
     * @return mixed
     */
    public function getDatum()
    {
        return $this->datum;
    }    /**
     * @param mixed $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }    /**
     * @return mixed
     */
    public function getOmschr()
    {
        return $this->omschr;
    }    /**
     * @param mixed $omschr
     */
    public function setOmschr($omschr)
    {
        $this->omschr = $omschr;
    }
    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
