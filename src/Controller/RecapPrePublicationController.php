<?php

namespace App\Controller;

use App\Repository\ChapitresRepository;
use App\Repository\CorrectionsRepository;
use App\Repository\HistoiresRepository;
use App\Repository\PieceJointeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecapPrePublicationController extends AbstractController
{
    #[Route('/recap/pre/publication/{id}', name: 'app_recap_pre_publication')]
    public function index(
        int $id,
        HistoiresRepository $histoiresRepo,
        ChapitresRepository $chapitresRepo,
        CorrectionsRepository $correctionsRepo
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        $histoire = $histoiresRepo->find($id);

        $chapitres = $chapitresRepo->findChapitresByHistoire($histoire);

        $correction = $correctionsRepo->findCorrectionsByHistoire($histoire);

        return $this->render('recap_pre_publication/index.html.twig', [
            'histoire' => $histoire,
            'correction' => $correction
        ]);
    }

    #[Route('/publication/{id}', name: 'app_publication')]
    public function publication(
        int $id,
        HistoiresRepository $histoiresRepo,
        ChapitresRepository $chapitresRepo,
        CorrectionsRepository $correctionsRepo,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');

        $histoire = $histoiresRepo->find($id);
        $chapitres = $chapitresRepo->findChapitresByHistoire($histoire);

        foreach ($chapitres as $chap) {
            $correction = $correctionsRepo->findCorrectionByChapitre($chap);
            if ($correction) {

                // Met à jour le contenu du chapitre
                $chap->setContenu($correction->getContenu());
                $em->persist($chap);

                // Supprime les pièces jointes
                foreach ($correction->getPieceJointes() as $pj) {
                    $correction->removePieceJointe($pj);
                    $em->remove($pj);
                }

                // Dissocie la correction du chapitre
                $chap->setCorrections(null);
                $em->persist($chap);

                // Supprime de la correction
                $em->remove($correction);
            }
        }

        // Met à jour de l'histoire
        $histoire->setDatePublication(new DateTime());
        $histoire = $histoiresRepo->changerStatutHistoireCvP($histoire);
        $em->persist($histoire);

        $em->flush();

        return $this->redirectToRoute('app_bibliotheque');
    }
}
