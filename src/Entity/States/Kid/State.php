<?php

namespace App\Entity\States\Kid;

use App\Entity\Kid;
use App\Repository\States\Kid\StateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StateRepository::class)]
#[ORM\Table(name: 'kid_states')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'state', type: Types::STRING)]
#[ORM\DiscriminatorMap([self::NEWBORN => Newborn::class, self::INFANT => Infant::class])]
abstract class State
{
    public const NEWBORN = 'newborn';
    public const INFANT = 'infant';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: Types::INTEGER, nullable: false)]
    protected int $id;

    #[ORM\OneToOne(inversedBy: 'state', targetEntity: Kid::class)]
    protected Kid $kid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKid(): ?Kid
    {
        return $this->kid;
    }

    public function setKid(Kid $kid): void
    {
        $this->kid = $kid;
    }
}