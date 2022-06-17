<?php

namespace App\Entity;

abstract class AbstractKid extends AbstractWard
{
    protected $id;

    protected $name;

    protected $dateOfBirth;

    protected $sex;
}
