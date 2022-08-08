<?php

namespace App\Entity;

use App\Entity\States\Kid\Infant;
use App\Entity\States\Kid\Newborn;
use App\Repository\Kid\AdultRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'adults')]
#[ORM\Entity(repositoryClass: AdultRepository::class)]
class Adult extends AbstractMinder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(name: 'surname', type: Types::STRING, length: 255)]
    private string $surname;

    #[ORM\ManyToOne(targetEntity: Kid::class, inversedBy: 'adults')]
    #[ORM\JoinColumn(name: 'kid_id', referencedColumnName: 'id')]
    private Newborn|Infant $kid;

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

    public function getKid(): Newborn|Infant
    {
        return $this->kid;
    }

    public function setKid(Newborn|Infant $kid): self
    {
        $this->kid = $kid;

        return $this;
    }
}
