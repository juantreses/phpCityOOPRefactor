<?php


class File
{
    private $name;
    private $tmpName;
    private $originalName;
    private $size;
    private $extension;
    private $targetLocation;
    private $formField;
    private $sqlField;

    public function __construct($file,$formField)
    {
        $file["name"] = strtolower($file["name"]);
        $this->originalName = $file["name"];
        $this->extension = pathinfo($this->originalName,PATHINFO_EXTENSION);
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
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName)
    {
        $this->originalName = $originalName;
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
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string|string[] $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
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