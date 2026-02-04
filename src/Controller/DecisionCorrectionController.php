<?php

namespace App\Controller;

use App\Entity\Corrections;
use App\Repository\CorrectionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Histoires;

final class DecisionCorrectionController extends AbstractController
{
    #[Route('/decision/{id}', name: 'app_decision_correction')]
    public function index(Histoires $histoire, CorrectionsRepository $correctionsRepository, int $id): Response
    { 

    $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        $chapitres= $histoire->getChapitres();
        
        $corrections=$correctionsRepository->findCorrectionByHistoire($id);

        

        return $this->render('decision_correction/index.html.twig', [
        'histoire' => $histoire,
        'chapitres'=> $chapitres,
        'correction'=> $corrections
        ]);
    }
}
