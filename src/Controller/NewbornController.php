<?php

namespace App\Controller;

use App\Entity\Adult;
use App\Entity\Newborn;
use App\Form\AdultType;
use App\Form\NewbornType;
use App\Repository\AdultRepository;
use App\Repository\NewbornRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

#[Route('/newborn', name: 'app_newborn')]
class NewbornController extends AbstractController
{
    public function __construct(
        public EventDispatcherInterface $eventDispatcher,
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

    #[Route('/{id}', name: '_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Newborn $newborn, AdultRepository $adultRepository): Response
    {
        $adult = new Adult();
        $adultForm = $this->createForm(AdultType::class, $adult);
        $adultForm->handleRequest($request);

        if ($adultForm->isSubmitted() && $adultForm->isValid()) {
            $newborn->addAdult($adult);
            $adultRepository->add($adult, true);
            $this->repository->add($newborn, true);

            return $this->redirectToRoute('app_newborn_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('newborn/show.html.twig', [
            'adult_form' => $adultForm,
            'newborn' => $newborn,
        ]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Newborn $newborn): Response
    {
        $form = $this->createForm(NewbornType::class, $newborn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($newborn, true);

            return $this->redirectToRoute('app_newborn_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('newborn/edit.html.twig', [
            'newborn' => $newborn,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Newborn $newborn): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newborn->getId(), $request->request->get('_token'))) {
            try {
                $this->repository->remove($newborn, true);
            } catch (Exception $exception) {
                throw new MethodNotAllowedException(
                    [],
                    sprintf('Something goes wrong. %s', $exception->getMessage()),
                    $exception->getCode()
                );
            }
        }

        return $this->redirectToRoute('app_newborn_index', [], Response::HTTP_SEE_OTHER);
    }
}
