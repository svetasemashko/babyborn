<?php

namespace App\Entity;

use App\Repository\KidRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: KidRepository::class)]
#[ORM\Table(name: 'kids')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([self::NEWBORN => Newborn::class, self::INFANT => Infant::class])]
abstract class AbstractKid extends AbstractWard
{
    public const NEWBORN = 'newborn';
    public const INFANT = 'infant';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: false)]
    protected int $id;

    #[ORM\Column(type: 'string', length: 200, nullable: false)]
    #[Assert\NotBlank]
    protected string $name;

    #[ORM\Column(type: 'datetime', nullable: false)]
    protected DateTimeInterface $dateOfBirth;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    protected string $sex;

    #[ORM\OneToMany(targetEntity: Adult::class, mappedBy: 'kid')]
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

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
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
}
