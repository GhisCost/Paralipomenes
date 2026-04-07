<?php

namespace App\Controller;

use App\Repository\HistoiresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;

final class ChoixCorrectionController extends AbstractController
{
    #[Route('/choix', name: 'app_choix_correction')]
    public function index(HistoiresRepository $histoiresRepository, HtmlSanitizerInterface $htmlSanitizer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CORRECTEUR');
        /**
         * @var User $user
         */

        $user = $this->getUser();

        $histoiresNouv = $histoiresRepository->trouverHistoiresDem();

        foreach ($histoiresNouv as $hist) {
            $derniers = $hist->getChapitres();
            foreach ($derniers as $d) {
                $d = $htmlSanitizer->sanitize($d->getContenu());
            }
        }

        $histoiresCom=$histoiresRepository->trouverHistoiresCorriByCorrecteur($user);

         foreach ($histoiresCom as $hist) {
            $derniers = $hist->getChapitres();
            foreach ($derniers as $d) {
                $d = $htmlSanitizer->sanitize($d->getContenu());
            }
        }

        return $this->render('choix_correction/index.html.twig', [
            'histoiresNouv' => $histoiresNouv,
            'user' => $user,
            'histoireCom'=> $histoiresCom
        ]);
    }
}
