<?php

namespace App\Entity;

use App\Repository\InfantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InfantRepository::class)]
class Infant extends AbstractKid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200, nullable: false)]
    #[Assert\NotBlank]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $dateOfBirth;

    #[ORM\Column(type: 'string', length: 100)]
    private $sex;

    #[ORM\OneToOne(inversedBy: 'infant', targetEntity: 'Newborn')]
    #[ORM\JoinColumn(name: 'newborn_id', referencedColumnName: 'id')]
    private $newborn;

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

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getNewborn(): ?Newborn
    {
        return $this->newborn;
    }

    public function setNewborn(?Newborn $newborn): self
    {
        $this->newborn = $newborn;

        return $this;
    }
}
