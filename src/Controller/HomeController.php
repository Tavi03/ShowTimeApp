<?php

namespace App\Controller;

use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FestivalRepository $festivalRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $limit = 3;
        $page = $request->query->getInt('page', 1);
        $search = $request->query->get('search', '');
        $sort = $request->query->get('sort', 'id');
        $offset = ($page - 1) * $limit;

        $festivalsOnPage = $festivalRepository->findFestivalsOnPage($entityManager, $search, $sort, $limit, $offset);
        $totalFestivals = $festivalRepository->findTotalFestivals($entityManager, $search, $sort, $limit, $offset);

        $totalPages = ceil($totalFestivals / $limit);
        $currentPage = $page;

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'festivals' => $festivalsOnPage,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalFestivals' => $totalFestivals,
            'limit' => $limit,
            'offset' => $offset,
        ]);
    }
}
