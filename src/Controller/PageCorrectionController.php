<?php

namespace App\Controller;

use App\Form\PageCorrectionType;
use App\Repository\ChapitresRepository;
use App\Repository\CorrectionsRepository;
use App\Repository\HistoiresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageCorrectionController extends AbstractController
{
    #[Route('/correction/{id}', name: 'app_page_correction')]
    public function index(
        Request $request, 
        CorrectionsRepository $correctionsRepository, 
        HistoiresRepository $histoiresRepository, 
        ChapitresRepository $chapitresRepository, 
        int $id,
        EntityManagerInterface $em
        ): Response {
        
        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        $chapitres=$chapitresRepository->findBy(['histoires'=>$id]);

   
        $corrections=$correctionsRepository->findCorrectionByHistoire($id);
    
    
        $form = $this->createForm(PageCorrectionType::class);
        $form->handleRequest($request);
        
       if ($form->isSubmitted() && $form->isValid()) {

        $html = $form->get('contenu')->getData();

        $blocs = explode('<!-- CORRECTION -->', $html);

        foreach ($corrections as $index => $correction) {
        if (isset($blocs[$index])) {
            $correction->setContenu(trim($blocs[$index]));
         }
    }
     
    $em->flush();

    $this->addFlash('success', 'Corrections enregistrées'); 
     }

        return $this->render('page_correction/index.html.twig', [
        'corrections'=>$corrections,
        'form' => $form->createView()
        ]);
    }

      #[Route('/debutcorrection/{id}', name: 'app_debut_correction')]
    public function premiereHistoire(
        Request $request, 
        CorrectionsRepository $correctionsRepository, 
        HistoiresRepository $histoiresRepository, 
        ChapitresRepository $chapitresRepository, 
        int $id,
        EntityManagerInterface $em
        ): Response {
        
        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        $chapitres=$chapitresRepository->findBy(['histoires'=>$id]);

        foreach($chapitres as $ch){
           
            $correctionsRepository->creerCorrection($this->getUser(), $ch, $ch->getHistoires());
        }

        $corrections=$correctionsRepository->findCorrectionByHistoire($id);
    
    
        $form = $this->createForm(PageCorrectionType::class);
        $form->handleRequest($request);
        
       if ($form->isSubmitted() && $form->isValid()) {

        $html = $form->get('contenu')->getData();

        $blocs = explode('<!-- CORRECTION -->', $html);

        foreach ($corrections as $index => $correction) {
        if (isset($blocs[$index])) {
            $correction->setContenu(trim($blocs[$index]));
         }
    }
     
    $em->flush();

    $this->addFlash('success', 'Corrections enregistrées'); 
     }

        return $this->render('page_correction/index.html.twig', [
        'corrections'=>$corrections,
        'form' => $form->createView()
        ]);
    }
}
