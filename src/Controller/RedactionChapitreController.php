<?php

namespace App\Controller;

use App\Entity\Histoires;
use App\Repository\HistoiresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\RedactionChapitreType;
use App\Entity\User;
use App\Entity\Chapitres;
use App\Repository\ChapitresRepository;

final class RedactionChapitreController extends AbstractController
{
    #[Route('/redaction/chapitre/{id}', name: 'app_redaction_chapitre')]
    public function index(Request $request, ChapitresRepository $chapitresRepository): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /**
         * @var Chapitres $chapitre
         */
        /**
         * @var Histoires $histoire
         */
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $histoire = $user->getHistoires();

        $chapitre = $chapitresRepository->findLastChapitreByHistoire($histoire);

        $form = $this->createForm(RedactionChapitreType::class, $chapitre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            dd(getContents());

        }


        return $this->render('redaction_chapitre/index.html.twig', [
            'controller_name' => 'RedactionChapitreController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/premiere/redaction/chapitre/{id}', 'app_debut_histoire')]
    public function debutHistoire(Request $request, HistoiresRepository $histoiresRepository, ChapitresRepository $chapitresRepository)
    {

        // $this->denyAccessUnlessGranted('IS_ANTHENTICATED_FULLY');

        /**
         * @var User $user
         */
        $user = $this->getUser();

        $histoire = $histoiresRepository->creerHistoire('Mon histoire (titre à modifier)', $user);

        $chapitre = $chapitresRepository->creerChapitre($histoire);

        $form = $this->createForm(RedactionChapitreType::class, $chapitre);
        $form->handleRequest($request);

        return $this->render('redaction_chapitre/index.html.twig', [
            'controller_name' => 'RedactionChapitreController',
            'form' => $form->createView()
        ]);

    }
}
