<?php


class AdminUser extends AbstractUser
{
    public function __construct()
    {
        $this->adminRights = true;
    }
}