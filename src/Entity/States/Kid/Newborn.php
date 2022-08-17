<?php

namespace App\Entity\States\Kid;

use App\Repository\States\Kid\NewbornRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewbornRepository::class)]
class Newborn extends State
{
    public function grow(): void
    {
        $this->kid->transitionTo(new Infant());
    }
}
