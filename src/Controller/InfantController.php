<?php

namespace App\Controller;

use App\Repository\States\Kid\InfantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/infant')]
class InfantController extends AbstractController
{
    public function __construct(
        public InfantRepository $repository,
    ) {
    }

    #[Route('/', name: 'app_infant_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('infant/index.html.twig', [
            'infants' => $this->repository->findAll(),
        ]);
    }
}
