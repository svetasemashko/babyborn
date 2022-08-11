<?php

namespace App\Entity;

use App\Entity\States\Kid\State;
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
class Kid extends AbstractWard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 200, nullable: false)]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column(name: 'birthDate', type: Types::DATETIME_MUTABLE, nullable: false)]
    private DateTimeInterface $dateOfBirth;

    #[ORM\Column(name: 'sex', type: Types::STRING, length: 100, nullable: false, enumType: Sex::class)]
    private Sex $sex;

    #[ORM\OneToMany(mappedBy: 'kid', targetEntity: Adult::class)]
    private Collection $adults;

    #[ORM\OneToOne(mappedBy: 'kid', targetEntity: State::class, cascade: ['persist'])]
    private State $state;

    public function __construct(State $state)
    {
        $this->adults = new ArrayCollection();
        $this->transitionTo($state);
    }

    public function transitionTo(State $state): void
    {
        $this->state = $state;
        $this->state->setKid($this);
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

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        if ($state === null && $this->state !== null) {
            $this->state->setKid(null);
        }

        if ($state !== null && $state->getKid() !== $this) {
            $state->setKid($this);
        }

        $this->state = $state;

        return $this;
    }
}