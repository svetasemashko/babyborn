<?php

namespace App\Controller;

use App\Entity\Newborn;
use App\Form\NewbornType;
use App\Repository\NewbornRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/newborn', name: 'app_newborn')]
class NewbornController extends AbstractController
{
    public function __construct(
        public EventDispatcherInterface $eventDispatcher
    ) {}

    #[Route('/', name: '_index', methods: ['GET'])]
    public function index(NewbornRepository $newbornRepository): Response
    {
        return $this->render('newborn/index.html.twig', [
            'newborns' => $newbornRepository->findAll(),
        ]);
    }

    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NewbornRepository $newbornRepository): Response
    {
        $newborn = new Newborn();
        $form = $this->createForm(NewbornType::class, $newborn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newbornRepository->add($newborn, true);

            return $this->redirectToRoute('app_newborn_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('newborn/new.html.twig', [
            'newborn' => $newborn,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(Newborn $newborn): Response
    {
        return $this->render('newborn/show.html.twig', [
            'newborn' => $newborn,
        ]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Newborn $newborn, NewbornRepository $newbornRepository): Response
    {
        $form = $this->createForm(NewbornType::class, $newborn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newbornRepository->add($newborn, true);

            return $this->redirectToRoute('app_newborn_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('newborn/edit.html.twig', [
            'newborn' => $newborn,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Newborn $newborn, NewbornRepository $newbornRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newborn->getId(), $request->request->get('_token'))) {
            $newbornRepository->remove($newborn, true);
        }

        return $this->redirectToRoute('app_newborn_index', [], Response::HTTP_SEE_OTHER);
    }
}
