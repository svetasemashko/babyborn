<?php

namespace App\Entity;

use App\Repository\NewbornRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NewbornRepository::class)]
class Newborn extends AbstractKid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Please, give a name.')]
    #[Assert\Regex('/^[a-zA-Z\s]+$/')]
    protected $name;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull]
    protected $dateOfBirth;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    #[Assert\NotNull]
    protected $sex;

    #[ORM\ManyToMany(targetEntity: "Adult", inversedBy: "newborn")]
    #[ORM\JoinTable(name: "newborns_adults")]
    #[ORM\JoinColumn(name: "newborn_id", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "adult_id", referencedColumnName: "id")]
    private $adult;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
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
}
