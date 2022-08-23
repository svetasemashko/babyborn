<?php

namespace App\Controller;

use App\Entity\Kid;
use App\Entity\States\Kid\Infant;
use App\Entity\States\Kid\Newborn;
use App\Form\KidType;
use App\Repository\AdultRepository;
use App\Repository\KidRepository;
use App\Service\KidMapper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

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

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kid/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_show', methods: ['GET', 'POST'])]
    public function show(Kid $kid, AdultRepository $adultRepository): Response
    {
        $adults = $adultRepository->findBy(['kid' => $kid->getId()]);

        return $this->renderForm('kid/show.html.twig', [
            'kid' => $kid,
            'adults' => $adults,
        ]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Kid $kid): Response
    {
        $form = $this->createForm(KidType::class, $kid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($kid, true);

            return $this->redirectToRoute('app_kid_show', ['id' => $kid->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kid/edit.html.twig', [
            'kid' => $kid,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Kid $kid): Response
    {
        if ($this->isCsrfTokenValid('delete' . $kid->getId(), $request->request->get('_token'))) {
            try {
                $this->repository->remove($kid, true);
            } catch (Exception $exception) {
                throw new MethodNotAllowedException(
                    [],
                    sprintf('Something goes wrong. %s', $exception->getMessage()),
                    $exception->getCode()
                );
            }
        }

        return $this->render('main/index.html.twig', []);
    }
}
