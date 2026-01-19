<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Histoires;
use App\Repository\HistoiresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RedactionChapitreType;
use App\Entity\User;
use App\Entity\Chapitres;
use App\Repository\ChapitresRepository;

final class PageHistoireController extends AbstractController
{
    #[Route('/histoire/{id}', name: 'app_page_histoire')]
    public function index(
        Request $request, 
        ChapitresRepository $chapitresRepository, 
        EntityManagerInterface $entityManager, 
        Histoires $histoire, 
        HistoiresRepository $histoiresRepository): Response
    {

        $chapitres= $histoire->getChapitres();

        return $this->render('page_histoire/index.html.twig', [
            'histoire' => $histoire,
            'chapitres'=> $chapitres
        ]);
    }
}
