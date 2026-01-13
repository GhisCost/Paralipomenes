<?php

namespace App\Controller;

use App\Entity\Histoires;
use App\Repository\HistoiresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\RedactionChapitreType;
use App\Entity\User;
use App\Entity\Chapitres;
use App\Repository\ChapitresRepository;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

final class RedactionChapitreController extends AbstractController
{
    #[Route('/redaction/chapitre/{id}', name: 'app_redaction_chapitre')]
    public function index(Request $request, ChapitresRepository $chapitresRepository, EntityManagerInterface $entityManager): Response
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

        if ($form->isSubmitted() && $form->isValid()) {

            $chapitre->setContenu($form->get('contenu')->getData());

            $entityManager->persist($chapitre);

            $entityManager->flush();

            return $this->render('redaction_chapitre/index.html.twig', [
                'form' => $form->createView(),
                'chapitre' => $chapitre
            ]);
        }

        return $this->render('redaction_chapitre/index.html.twig', [
            'form' => $form->createView(),
            'chapitre' => $chapitre
        ]);
    }

    #[Route('/premiere/redaction/chapitre/{id}', 'app_debut_histoire')]
    public function debutHistoire(Request $request, HistoiresRepository $histoiresRepository, ChapitresRepository $chapitresRepository)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /**
         * @var User $user
         */
        $user = $this->getUser();

        $histoire = $histoiresRepository->creerHistoire('Mon histoire (titre à modifier)', $user);

        $chapitre = $chapitresRepository->creerChapitre($histoire);

        $form = $this->createForm(RedactionChapitreType::class, $chapitre);
        $form->handleRequest($request);

        return $this->render('redaction_chapitre/index.html.twig', [
            'form' => $form->createView(),
            'chapitre' => $chapitre
        ]);

    }

    #[Route('/chapitre/suivant/{id}', name: 'app_chapitre_suivant')]
    public function chapitreSuivant(
        Chapitres $chapitre,
        Request $request,
        ChapitresRepository $chapitresRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($chapitre->getHistoires()->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $chapitreActuel = $chapitresRepository->findChapitreSuivant($chapitre);

        if ($chapitreActuel === null) {
            /**
             * @var User $user
             */
            $user = $this->getUser();
            $histoire = $user->getHistoires();
            $chapitreActuel = $chapitresRepository->creerChapitre($histoire);

            $form = $this->createForm(RedactionChapitreType::class, $chapitreActuel);
            $form->handleRequest($request);

            return $this->render('redaction_chapitre/index.html.twig', [
                'form' => $form->createView(),
                'chapitre' => $chapitreActuel
            ]);
        }

        $form = $this->createForm(RedactionChapitreType::class, $chapitreActuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chapitreActuel->setContenu($form->get('contenu')->getData());

            $entityManager->persist($chapitreActuel);

            $entityManager->flush();

            return $this->redirectToRoute("app_chapitre_suivant", ["id" => $chapitre->getId()]);
        }

        return $this->render('redaction_chapitre/index.html.twig', [
            'form' => $form->createView(),
            'chapitre' => $chapitreActuel
        ]);
    }

    #[Route('/chapitre/precedent/{id}', name: 'app_chapitre_precedent')]
    public function chapitrePrecedent(
        Chapitres $chapitre,
        Request $request,
        ChapitresRepository $chapitresRepository,
        EntityManagerInterface $entityManager,
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($chapitre->getHistoires()->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $chapitreActuel = $chapitresRepository->findChapitrePrecedent($chapitre);
        if ($chapitreActuel === null) {
            $chapitreActuel = $chapitre;
        }
        $form = $this->createForm(RedactionChapitreType::class, $chapitreActuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $chapitreActuel->setContenu($form->get('contenu')->getData());
            $entityManager->persist($chapitreActuel);
            $entityManager->flush();

            return $this->redirectToRoute("app_chapitre_precedent", ["id" => $chapitre->getId()]);
        }

        return $this->render('redaction_chapitre/index.html.twig', [
            'form' => $form->createView(),
            'chapitre' => $chapitreActuel
        ]);
    }

}
