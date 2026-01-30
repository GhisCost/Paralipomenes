<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Histoires;
use App\Repository\HistoiresRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ChapitresRepository;

final class DecisionCorrectionController extends AbstractController
{
    #[Route('/decision/{id}', name: 'app_decision_correction')]
    public function index(Histoires $histoire): Response
    { 

    $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        $chapitres= $histoire->getChapitres();

        return $this->render('decision_correction/index.html.twig', [
        'histoire' => $histoire,
        'chapitres'=> $chapitres
        ]);
    }
}
