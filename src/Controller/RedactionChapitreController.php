<?php

namespace App\Controller;

use App\Entity\Histoires;
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
        
        $user= $this->getUser();

        $histoire= $user->getHistoires();

        $chapitre=  $chapitresRepository->findLastChapitreByHistoire($histoire);
        
        $form=$this->createForm(RedactionChapitreType::class,$chapitre);

        $form->handleRequest($request);

        return $this->render('redaction_chapitre/index.html.twig', [
            'controller_name' => 'RedactionChapitreController',
            'form' =>$form->createView()
        ]);
    }
}
