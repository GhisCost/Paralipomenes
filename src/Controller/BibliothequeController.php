<?php

namespace App\Controller;

use App\Repository\HistoiresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BibliothequeController extends AbstractController
{
    #[Route('/bibliotheque', name: 'app_bibliotheque')]
    public function index(HistoiresRepository $histoiresRepository): Response
    {

        $histoires=$histoiresRepository->trouverHistoires();

        return $this->render('bibliotheque/index.html.twig', [
            'controller_name' => 'BibliothequeController',
            'histoires'=> $histoires
        ]);
    }
}
