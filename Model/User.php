<?php
class User extends AbstractUser
{
      
    public function __construct()
    {
        $this->adminRights = false;
    }
}