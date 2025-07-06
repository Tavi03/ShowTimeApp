<?php

namespace App\Controller;

use App\Repository\FestivalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FestivalRepository $festivalRepository, Request $request): Response
    {
        $limit = 3;
        $page = $request->query->getInt('page', 1);
        $offset = ($page - 1) * $limit;
        $totalFestivals = $festivalRepository->count();
        $festivals = $festivalRepository->findBy([], ['id' => 'ASC'], $limit, $offset);

        $totalPages = ceil($totalFestivals / $limit);
        $currentPage = $page;

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'festivals' => $festivals,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalFestivals' => $totalFestivals,
            'limit' => $limit,
            'offset' => $offset,
        ]);
    }
}
