<?php

namespace App\Command;

use App\Entity\Newborn;
use App\Event\BecameInfantEvent;
use App\Repository\NewbornRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'app:check-is-infant',
    description: 'Check is age suits for infant.',
    hidden: false,
)]
class CheckIsInfantCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $dispatcher,
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
            try {
                $event = new BecameInfantEvent($newborn);
                $this->dispatcher->dispatch($event, BecameInfantEvent::NAME);
            } catch (\Throwable $e) {
                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}