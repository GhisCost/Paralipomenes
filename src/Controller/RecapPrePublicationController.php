<?php

namespace App\Controller;

use App\Repository\ChapitresRepository;
use App\Repository\CorrectionsRepository;
use App\Repository\HistoiresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecapPrePublicationController extends AbstractController
{
    #[Route('/recap/pre/publication/{id}', name: 'app_recap_pre_publication')]
    public function index(int $id, 
    HistoiresRepository $histoiresRepo, 
    ChapitresRepository $chapitresRepo, 
    CorrectionsRepository $correctionsRepo): Response
    {     
        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        $histoire=$histoiresRepo->find($id);
        
        $chapitres=$chapitresRepo->findChapitresByHistoire($histoire);

        $correction=$correctionsRepo->findCorrectionsByHistoire($histoire);

        return $this->render('recap_pre_publication/index.html.twig', [
        'histoire'=>$histoire,
        'correction'=>$correction
        ]);
    }
}
