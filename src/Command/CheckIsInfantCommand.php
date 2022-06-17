<?php

namespace App\Command;

use App\Entity\Infant;
use App\Entity\Newborn;
use App\Repository\NewbornRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:check-is-infant',
    description: 'Check is age suits for infant.',
    hidden: false,
)]
class CheckIsInfantCommand extends Command
{
    public function __construct(
        public EntityManagerInterface $entityManager
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var NewbornRepository $newbornRepository */
        $newbornRepository = $this->entityManager->getRepository(Newborn::class);

        $dateToBecameInfant = new \DateTime();
        $dateToBecameInfant->modify(NewbornRepository::TIME_FROM_BIRTH);

        $newborns = $newbornRepository->findByDateOfBecameInfant($dateToBecameInfant);

        foreach ($newborns as $newborn) {
            $infant = new Infant();
            $infant
                ->setName($newborn->getName())
                ->setDateOfBirth($newborn->getDateOfBirth())
                ->setSex($newborn->getSex());

            $this->entityManager->persist($infant);
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}