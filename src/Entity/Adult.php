<?php

namespace App\Entity;

use App\Repository\AdultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdultRepository::class)]
class Adult extends AbstractMinder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $surname;

    #[ORM\ManyToMany(targetEntity: "Newborn", mappedBy: "adults")]
    private $newborns;

    public function __construct()
    {
        $this->newborns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getNewborns(): Collection
    {
        return $this->newborns;
    }

    public function addNewborn(Newborn $newborn): self
    {
        if (!$this->newborns->contains($newborn)) {
            $this->newborns[] = $newborn;
            $newborn->addAdult($this);
        }

        return $this;
    }

    public function removeNewborn(Newborn $newborn): self
    {
        if (!$this->newborns->removeElement($newborn)) {
            $newborn->removeAdult($this);
        }

        return $this;
    }
}
