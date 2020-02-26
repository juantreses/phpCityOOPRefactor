<?php


class file
{
    private $name;
    private $tmpName;
    private $origanalName;
    private $size;
    private $extention;
    private $targetLocation;
    private $formField;
    private $sqlField;

    public function __construct($file,$formField)
    {
        $file["name"] = strtolower($file["name"]);
        $this->origanalName = $file["name"];
        $this->extention = pathinfo($this->origanalName,PATHINFO_EXTENSION);
        $this->size = $file["size"];
        $this->formField = $formField;
        $this->tmpName = $file['tmp_name'];
    }
    /**
     * @return mixed
     */
    public function getFormField()
    {
        return $this->formField;
    }

    /**
     * @param mixed $formField
     */
    public function setFormField($formField): void
    {
        $this->formField = $formField;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTmpName()
    {
        return $this->tmpName;
    }

    /**
     * @param mixed $tmpName
     */
    public function setTmpName($tmpName)
    {
        $this->tmpName = $tmpName;
    }

    /**
     * @return string
     */
    public function getOriganalName()
    {
        return $this->origanalName;
    }

    /**
     * @param string $origanalName
     */
    public function setOriganalName(string $origanalName)
    {
        $this->origanalName = $origanalName;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string|string[]
     */
    public function getExtention()
    {
        return $this->extention;
    }

    /**
     * @param string|string[] $extention
     */
    public function setExtention($extention)
    {
        $this->extention = $extention;
    }

    /**
     * @return mixed
     */
    public function getTargetLocation()
    {
        return $this->targetLocation;
    }

    /**
     * @param mixed $targetLocation
     */
    public function setTargetLocation($targetLocation,$newName,$sqlField)
    {
        $this->name = $newName;
        $this->targetLocation = $targetLocation.$newName;
        $this->sqlField = $sqlField;
    }

    /**
     * @return mixed
     */
    public function getSqlField()
    {
        return $this->sqlField;
    }

}