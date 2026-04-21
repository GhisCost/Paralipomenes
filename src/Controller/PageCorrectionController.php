<?php

namespace App\Controller;

use App\Entity\Corrections;
use App\Entity\Histoires;
use App\Form\PageCorrectionType;
use App\Form\TitreHistoireType;
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

        $corrections = $correctionsRepository->findUneCorrecByHistoire($id);

        $correction = $corrections[0];

        $form = $this->createForm(PageCorrectionType::class, $correction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
        }

        $histoire = $correction->getHistoire();

        if (!$correctionsRepository->findCorrectionPrecedente($correction)) {
            $precedent = 0;
        } else {
            $precedent = 1;
        }

        if (!$correctionsRepository->findCorrectionSuivante($correction)) {
            $suivant = 0;
        } else {
            $suivant = 1;
        }

        $formTitre = $this->createForm(TitreHistoireType::class, $histoire);
        $formTitre->handleRequest($request);

        if ($formTitre->isSubmitted() && $formTitre->isValid()) {
            $em->persist($histoire);
            $em->flush();
            $this->addFlash('success', 'Le titre a été mis à jour.');
            return $this->redirectToRoute('app_page_correction', ['id' => $histoire->getId()]);
        }

        return $this->render('page_correction/index.html.twig', [
            'correction' => $correction,
            'formChapitre' => $form->createView(),
            'histoire' => $histoire,
            'precedent' => $precedent,
            'suivant' => $suivant,
            'formTitre' => $formTitre->createView()
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

        $corrections = $correctionsRepository->findUneCorrecByHistoire($id);

        $chapitres = $chapitresRepository->findBy(['histoires' => $histoire], ['id' => 'ASC']);

        foreach ($chapitres as $chapitre) {
            $correctionsRepository->creerCorrection(
                $this->getUser(),
                $chapitre,
                $histoire
            );
        }
        $corrections = $correctionsRepository->findUneCorrecByHistoire($id);

        $histoire = $histoiresRepository->changerStatutHistoireDvC($histoire);

        return $this->redirectToRoute('app_page_correction', [
            'id' => $id,
        ]);
    }

    #[Route('/correctionsuivante/{id}', name: 'app_correction_suivante')]

    public function correctionsuivante(
        Request $request,
        CorrectionsRepository $correctionsRepository,
        EntityManagerInterface $em,
        int $id,

    ) {
        // dd($id);
        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        /**
         * @var Corrections $correction
         */
        $correctionPrecedente = $correctionsRepository->find($id);

        if (!$correctionPrecedente) {
            throw $this->createNotFoundException('Correction introuvable');
        }

        $correction = $correctionsRepository->findCorrectionSuivante($correctionPrecedente);

        $form = $this->createForm(PageCorrectionType::class, $correction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
        }

        if (!$correctionsRepository->findCorrectionPrecedente($correction)) {
            $precedent = 0;
        } else {
            $precedent = 1;
        }

        if (!$correctionsRepository->findCorrectionSuivante($correction)) {
            $suivant = 0;
        } else {
            $suivant = 1;
        }

        $histoire = $correction->getHistoire();


        $formTitre = $this->createForm(TitreHistoireType::class, $histoire);
        $formTitre->handleRequest($request);

        if ($formTitre->isSubmitted() && $formTitre->isValid()) {
            $em->persist($histoire);
            $em->flush();
            $this->addFlash('success', 'Le titre a été mis à jour.');
            return $this->redirectToRoute('app_page_correction', ['id' => $histoire->getId()]);
        }


        return $this->render('page_correction/index.html.twig', [
            'correction' => $correction,
            'formChapitre' => $form->createView(),
            'histoire' => $histoire,
            'precedent' => $precedent,
            'suivant' => $suivant,
            'formTitre' => $formTitre->createView()
        ]);

    }

    #[Route('/correctionprecedente/{id}', name: 'app_correction_precedente')]

    public function correctionprecedente(
        Request $request,
        CorrectionsRepository $correctionsRepository,
        EntityManagerInterface $em,
        int $id,

    ) {
        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        /**
         * @var Corrections $correction
         */
        $correctionSuivante = $correctionsRepository->find($id);

        if (!$correctionSuivante) {
            throw $this->createNotFoundException('Correction introuvable');
        }

        $correction = $correctionsRepository->findCorrectionPrecedente($correctionSuivante);

        $form = $this->createForm(PageCorrectionType::class, $correction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
        }

        if (!$correctionsRepository->findCorrectionPrecedente($correction)) {
            $precedent = 0;
        } else {
            $precedent = 1;
        }

        if (!$correctionsRepository->findCorrectionSuivante($correction)) {
            $suivant = 0;
        } else {
            $suivant = 1;
        }

        $histoire = $correction->getHistoire();

        $formTitre = $this->createForm(TitreHistoireType::class, $histoire);
        $formTitre->handleRequest($request);

        if ($formTitre->isSubmitted() && $formTitre->isValid()) {
            $em->persist($histoire);
            $em->flush();
            $this->addFlash('success', 'Le titre a été mis à jour.');
            return $this->redirectToRoute('app_page_correction', ['id' => $histoire->getId()]);
        }

        return $this->render('page_correction/index.html.twig', [
            'correction' => $correction,
            'formChapitre' => $form->createView(),
            'histoire' => $histoire,
            'precedent' => $precedent,
            'suivant' => $suivant,
            'formTitre' => $formTitre->createView()

        ]);

    }

}
