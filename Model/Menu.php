<?php


class Menu
{
    private $id;
    private $caption;
    private $destination;
    private $order;
    private $active;
    private $srOnly;

    public function __construct($dataRow)
    {
        $this->caption = $dataRow['men_caption'];
        $this->destination = $dataRow['men_destination'];
        $this->order = $dataRow['men_order'];
        $this->id = $dataRow['men_id'];
        $this->active = " ";
        $this->srOnly = " ";
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }

    /**
     * @param string $active
     */
    public function setActive(string $active): void
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getSrOnly(): string
    {
        return $this->srOnly;
    }

    /**
     * @param string $srOnly
     */
    public function setSrOnly(string $srOnly): void
    {
        $this->srOnly = $srOnly;
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
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param mixed $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param mixed $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

}