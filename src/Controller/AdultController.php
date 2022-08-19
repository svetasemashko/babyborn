<?php

namespace App\Controller;

use App\Entity\Adult;
use App\Form\AdultType;
use App\Repository\AdultRepository;
use App\Repository\KidRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/adult', name: 'app_adult')]
class AdultController extends AbstractController
{
    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AdultRepository $adultRepository, KidRepository $kidRepository): Response
    {
        $adult = new Adult();

        $options = [
            'kidRepository' => $kidRepository,
        ];
        $form = $this->createForm(AdultType::class, $adult, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adultRepository->add($adult, true);

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kid/new.html.twig', [
            'form' => $form,
        ]);
    }
}