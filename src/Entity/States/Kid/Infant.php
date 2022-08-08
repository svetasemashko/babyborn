<?php

namespace App\Entity\States\Kid;

use App\Repository\Kid\InfantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfantRepository::class)]
class Infant extends State
{
}
