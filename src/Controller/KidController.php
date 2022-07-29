<?php

namespace App\Controller;

use App\Entity\Infant;
use App\Entity\Newborn;
use App\Form\KidType;
use App\Repository\KidRepository;
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
    ) {}

    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(Request $request, KidMapper $kidMapper): Response
    {
        $form = $this->createForm(KidType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $kidGroup = $kidMapper->identifyByDateOfBirth($data['dateOfBirth']);

            $kid = match ($kidGroup) {
                'newborn' => new Newborn(),
                'infant' => new Infant(),
            };
            $kid
                ->setName($data['name'])
                ->setDateOfBirth($data['dateOfBirth'])
                ->setSex($data['sex'])
                ->setActive(true);

            $this->repository->add($kid, true);

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kid/new.html.twig', [
            'form' => $form,
        ]);
    }
}
