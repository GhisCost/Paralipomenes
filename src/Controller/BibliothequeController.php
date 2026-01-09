<?php

namespace App\Controller;

use App\Repository\HistoiresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

final class BibliothequeController extends AbstractController
{
    #[Route('/bibliotheque', name: 'app_bibliotheque')]
    public function index(HistoiresRepository $histoiresRepository,HtmlSanitizerInterface $htmlSanitizer): Response
    {

        $histoires=$histoiresRepository->trouverHistoires();

          foreach($histoires as $hist){
            $derniers = $hist->getChapitres();
            foreach($derniers as $d){
               $d=$htmlSanitizer->sanitize($d->getContenu());
            }
        }

        return $this->render('bibliotheque/index.html.twig', [
            'controller_name' => 'BibliothequeController',
            'histoires'=> $histoires
        ]);
    }
}
