<?php

namespace CMS\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Credentials

 */
class Credentials
{

    private $login;

    private $password;


    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
}

