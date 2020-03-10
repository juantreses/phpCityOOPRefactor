<?php


class AdminUser extends AbstractUser
{
    private $adminPower;

    public function __construct()
    {
        $this->adminPower = rand(0, 100);
        $this->adminRights = true;
    }

    public function getAdminPower()
    {
        return $this->adminPower;
    }
}