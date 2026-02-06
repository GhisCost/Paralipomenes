<?php

namespace App\Controller;

use App\Entity\Corrections;
use App\Entity\Histoires;
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
        EntityManagerInterface $em,
        int $id
    ): Response {

        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');



        /**
         * @var Corrections $correction
         */

        $corrections = $correctionsRepository->findCorrectionByHistoire($id);

        $correction = $corrections[0];

        $form = $this->createForm(PageCorrectionType::class, $correction);
   
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
        }

        $histoire = $correction->getHistoire();

        // dd($form);

        return $this->render('page_correction/index.html.twig', [
            'correction' => $correction,
            'form' => $form->createView(),
            'histoire' => $histoire
        ]);
    }

    #[Route('/debutcorrection/{id}', name: 'app_debut_correction')]
    public function premiereCorrection(
        int $id,
        CorrectionsRepository $correctionsRepository,
        HistoiresRepository $histoiresRepository,
        ChapitresRepository $chapitresRepository,
        EntityManagerInterface $em
    ): Response {

        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        $histoire = $histoiresRepository->find($id);

        if (!$histoire) {
            throw $this->createNotFoundException('Histoire introuvable');
        }

        $corrections = $correctionsRepository->findCorrectionByHistoire($id);

        $chapitres = $chapitresRepository->findBy(['histoires' => $histoire], ['id' => 'ASC']);

        foreach ($chapitres as $chapitre) {
            $correctionsRepository->creerCorrection(
                $this->getUser(),
                $chapitre,
                $histoire
            );
        }
        $corrections = $correctionsRepository->findCorrectionByHistoire($id);

        return $this->redirectToRoute('app_page_correction', [
            'id' => $id,
        ]);
    }
}
