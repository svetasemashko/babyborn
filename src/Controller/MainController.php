<?php

namespace App\Controller;

use App\Service\StatisticCollector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', []);
    }

    #[Route('/statistics', name: 'app_stats')]
    public function getStatistics(StatisticCollector $statisticCollector): Response
    {
        return $this->render('main/statistics.html.twig', $statisticCollector->getAllData());
    }
}
