<?php

namespace App\Entity;

use App\Enum\Sex;
use App\Repository\KidRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: KidRepository::class)]
#[ORM\Table(name: 'kids')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'discr', type: Types::STRING, )]
#[ORM\DiscriminatorMap([self::NEWBORN => Newborn::class, self::INFANT => Infant::class])]
abstract class AbstractKid extends AbstractWard
{
    public const NEWBORN = 'newborn';
    public const INFANT = 'infant';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: Types::INTEGER, nullable: false)]
    protected int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 200, nullable: false)]
    #[Assert\NotBlank]
    protected string $name;

    #[ORM\Column(name: 'birthDate', type: Types::DATETIME_MUTABLE, nullable: false)]
    protected DateTimeInterface $dateOfBirth;

    #[ORM\Column(name: 'sex', type: Types::STRING, length: 100, nullable: false, enumType: Sex::class)]
    protected Sex $sex;

    #[ORM\Column(name: 'active', type: Types::BOOLEAN, length: 20, nullable: false)]
    protected bool $active;

    #[ORM\OneToMany(mappedBy: 'kid', targetEntity: Adult::class)]
    protected Collection $adults;

    public function __construct()
    {
        $this->adults = new ArrayCollection();
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

    public function getDateOfBirth(): ?DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getSex(): Sex
    {
        return $this->sex;
    }

    public function setSex(Sex $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getAdults(): Collection
    {
        return $this->adults;
    }

    public function addAdult(Adult $adult): self
    {
        if (!$this->adults->contains($adult)) {
            $this->adults[] = $adult;
        }

        return $this;
    }

    public function removeAdult(Adult $adult): self
    {
        $this->adults->removeElement($adult);

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
