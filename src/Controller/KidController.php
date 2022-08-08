<?php

namespace App\Controller;

use App\Entity\Kid;
use App\Entity\States\Kid\Infant;
use App\Entity\States\Kid\Newborn;
use App\Form\KidType;
use App\Repository\KidRepository;
use App\Repository\States\Kid\StateRepository;
use App\Service\KidMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/kid', name: 'app_kid')]
class KidController extends AbstractController
{
    public function __construct(
        public KidRepository $repository,
        public StateRepository $stateRepository,
    ) {}

    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(Request $request, KidMapper $kidMapper): Response
    {
        $form = $this->createForm(KidType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $kidState = $kidMapper->identifyByDateOfBirth($data['dateOfBirth']);

            /** @var Newborn|Infant $state */
            $state = match ($kidState) {
                'newborn' => new Newborn(),
                'infant' => new Infant(),
            };
            $kid = new Kid($state);

            $kid
                ->setName($data['name'])
                ->setDateOfBirth($data['dateOfBirth'])
                ->setSex($data['sex'])
            ;

            $this->repository->add($kid, true);
            $this->stateRepository->add($state, true);

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kid/new.html.twig', [
            'form' => $form,
        ]);
    }
}
