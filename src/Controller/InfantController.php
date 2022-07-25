<?php

namespace App\Controller;

use App\Entity\Infant;
use App\Form\InfantType;
use App\Repository\AdultRepository;
use App\Repository\InfantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/infant')]
class InfantController extends AbstractController
{
    #[Route('/', name: 'app_infant_index', methods: ['GET'])]
    public function index(InfantRepository $infantRepository): Response
    {
        return $this->render('infant/index.html.twig', [
            'infants' => $infantRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_infant_show', methods: ['GET'])]
    public function show(Infant $infant, AdultRepository $adultRepository): Response
    {
        $adults = $adultRepository->findAllByInfant($infant);

        return $this->render('infant/show.html.twig', [
            'infant' => $infant,
            'adults' => $adults,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_infant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Infant $infant, InfantRepository $infantRepository): Response
    {
        $form = $this->createForm(InfantType::class, $infant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infantRepository->add($infant, true);

            return $this->redirectToRoute('app_infant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('infant/edit.html.twig', [
            'infant' => $infant,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_infant_delete', methods: ['POST'])]
    public function delete(Request $request, Infant $infant, InfantRepository $infantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$infant->getId(), $request->request->get('_token'))) {
            $infantRepository->remove($infant, true);
        }

        return $this->redirectToRoute('app_infant_index', [], Response::HTTP_SEE_OTHER);
    }
}
