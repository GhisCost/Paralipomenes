<?php

namespace App\Controller;

use App\Repository\HistoiresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;
use Doctrine\Common\Collections\Criteria;

final class BibliothequeController extends AbstractController
{
    #[Route('/bibliotheque', name: 'app_bibliotheque')]
    public function index(HistoiresRepository $histoiresRepository, HtmlSanitizerInterface $htmlSanitizer): Response
    {

        $histoires = $histoiresRepository->trouverHistoires();

        foreach ($histoires as $hist) {
            $derniers = $hist->getChapitres();
            foreach ($derniers as $d) {
                $d = $htmlSanitizer->sanitize($d->getContenu());
            }
        }

        return $this->render('bibliotheque/index.html.twig', [
            'histoires' => $histoires
        ]);
    }


    #[Route('/recherche-histoires', name: 'app_recherche_histoires', methods: ['GET'])]
    public function rechercheHistoires(
        HistoiresRepository $histoiresRepository,
        Request $request
    ): JsonResponse {
        $mot = $request->query->get('mot', '');

        if (strlen($mot) < 2) {
            return new JsonResponse([]);
        }

        $histoires = $histoiresRepository->createQueryBuilder('h')
            ->leftJoin('h.chapitres', 'c')
            ->where('h.titre LIKE :mot OR c.contenu LIKE :mot')
            ->setParameter('mot', '%' . $mot . '%')
            ->groupBy('h.id')
            ->getQuery()
            ->getResult();

        $ids = array_map(fn($h) => $h->getId(), $histoires);

        dump($ids); 

        return new JsonResponse($ids);
    }
}
