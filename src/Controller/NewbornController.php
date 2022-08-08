<?php

namespace App\Controller;

use App\Repository\States\Kid\NewbornRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/newborn', name: 'app_newborn')]
class NewbornController extends AbstractController
{
    public function __construct(
        public NewbornRepository $repository,
    ) {
    }

    #[Route('/', name: '_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('newborn/index.html.twig', [
            'newborns' => $this->repository->findAll(),
        ]);
    }
}
