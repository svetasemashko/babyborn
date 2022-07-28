<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\InfantRepository;

#[ORM\Entity(repositoryClass: InfantRepository::class)]
class Infant extends AbstractKid
{
}
