<?php

namespace Andrei\Model;

use Andrei\App\Db\AbstractMysqlModel;

class User extends AbstractMysqlModel
{

    protected $table = 'users';
    protected $emailColumn;
    protected $firstNameColumn;
    protected $lastNameColumn;


    public function setEmail($email)
    {
        $this->emailColumn = $email;
    }

    public function getEmail()
    {
        return $this->emailColumn;
    }

    public function setFirstname($firstName)
    {
        $this->firstNameColumn = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstNameColumn;
    }

    public function setLastName($lastName)
    {
        $this->lastNameColumn = $lastName;
    }

    public function getLastName()
    {
        return $this->lastNameColumn;
    }
}
