<?php

namespace App\Controller;

use App\Entity\Actions\Feedings\Feeding;
use App\Entity\Kid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedingController extends AbstractController
{
    #[Route('/{id}/feed', name: 'feed', requirements: ['id' => '\d+'])]
    public function feedUp(Kid $kid): Response
    {
        $feeding = new Feeding($kid->getState());
        $feeding->execute();

        return $this->redirectToRoute('app_main');
    }
}