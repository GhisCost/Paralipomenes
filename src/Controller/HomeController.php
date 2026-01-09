<?php

namespace App\Controller;

use App\Entity\Chapitres;
use App\Repository\HistoiresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HistoiresRepository $histoiresRepository,HtmlSanitizerInterface $htmlSanitizer): Response
    {
        $dernieresHistoires=$histoiresRepository->troisDernièresHistoires();
        
        foreach($dernieresHistoires as $der){
            $derniers = $der->getChapitres();
            foreach($derniers as $d){
               $d=$htmlSanitizer->sanitize($d->getContenu());
            }
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'derniereHistoire' => $dernieresHistoires
        ]);
    }
}
