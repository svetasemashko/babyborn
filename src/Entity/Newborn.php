<?php

namespace App\Entity;

use App\Repository\NewbornRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewbornRepository::class)]
class Newborn extends AbstractKid
{
}
