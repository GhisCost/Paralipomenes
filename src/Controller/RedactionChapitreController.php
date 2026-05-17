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
use App\Form\TitreHistoireType;

final class RedactionChapitreController extends AbstractController
{
    #[Route('/redaction/chapitre/{id}', name: 'app_redaction_chapitre')]
    public function index(Request $request, ChapitresRepository $chapitresRepository, EntityManagerInterface $entityManager): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** annotation phpDoc pour expliquer à VSCode de quel type sont les variables*/
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

    $formChapitre = $this->createForm(RedactionChapitreType::class, $chapitre);
    $formChapitre->handleRequest($request);
    $formTitre = $this->createForm(TitreHistoireType::class, $histoire);
    $formTitre->handleRequest($request);

    if ($formChapitre->isSubmitted() && $formChapitre->isValid()) {
        $chapitre->setContenu($formChapitre->get('contenu')->getData());
        $entityManager->persist($chapitre);
        $entityManager->flush();
        return $this->render('redaction_chapitre/index.html.twig', [
            'formChapitre' => $formChapitre->createView(),
            'formTitre' => $formTitre->createView(),
            'chapitre' => $chapitre,
            'histoire' => $histoire,
        ]);
    }

    if ($formTitre->isSubmitted() && $formTitre->isValid()) {
        $entityManager->persist($histoire);
        $entityManager->flush();
        $this->addFlash('success', 'Le titre a été mis à jour.');
        return $this->redirectToRoute('app_redaction_chapitre', ['id' => $chapitre->getId()]);
    }

    return $this->render('redaction_chapitre/index.html.twig', [
        'formChapitre' => $formChapitre->createView(),
        'formTitre' => $formTitre->createView(),
        'chapitre' => $chapitre,
        'histoire' => $histoire,
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

        $chapitre = $chapitresRepository->creerChapitre($histoire, 0);

        return $this->redirectToRoute("app_redaction_chapitre",["id"=>$user->getId()]);

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
    
    /**
    * @var User $user
    */

    $user = $this->getUser();
    $histoire = $user->getHistoires();

    if ($chapitreActuel === null) {
        $chapitreActuel = $chapitresRepository->creerChapitre($histoire, $chapitre->getNumeroChapitre());
    }

    $formChapitre = $this->createForm(RedactionChapitreType::class, $chapitreActuel);
    $formChapitre->handleRequest($request);

    if ($formChapitre->isSubmitted() && $formChapitre->isValid()) {
        $chapitreActuel->setContenu($formChapitre->get('contenu')->getData());
        $entityManager->persist($chapitreActuel);
        $entityManager->flush();
        return $this->redirectToRoute("app_redaction_chapitre", ["id" => $chapitreActuel->getId()]);
    }

   
    $formTitre = $this->createForm(TitreHistoireType::class, $histoire);
    $formTitre->handleRequest($request);

    if ($formTitre->isSubmitted() && $formTitre->isValid()) {
        $entityManager->persist($histoire);
        $entityManager->flush();
        $this->addFlash('success', 'Le titre a été mis à jour.');
        return $this->redirectToRoute('app_redaction_chapitre', ['id' => $chapitreActuel->getId()]);
    }

    return $this->render('redaction_chapitre/index.html.twig', [
        'formChapitre' => $formChapitre->createView(),
        'formTitre' => $formTitre->createView(),
        'chapitre' => $chapitreActuel,
        'histoire' => $histoire,
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

      /**
      * @var User $user
     */

    $user = $this->getUser();
    $histoire = $user->getHistoires();

    if ($chapitreActuel === null) {
        $chapitreActuel = $chapitre;
    }

    $formChapitre = $this->createForm(RedactionChapitreType::class, $chapitreActuel);
    $formChapitre->handleRequest($request);

    if ($formChapitre->isSubmitted() && $formChapitre->isValid()) {
        $chapitreActuel->setContenu($formChapitre->get('contenu')->getData());
        $entityManager->persist($chapitreActuel);
        $entityManager->flush();
        return $this->redirectToRoute("app_redaction_chapitre", ["id" => $chapitreActuel->getId()]);
    }

    $formTitre = $this->createForm(TitreHistoireType::class, $histoire);
    $formTitre->handleRequest($request);

    if ($formTitre->isSubmitted() && $formTitre->isValid()) {
        $entityManager->persist($histoire);
        $entityManager->flush();
        $this->addFlash('success', 'Le titre a été mis à jour.');
        return $this->redirectToRoute('app_redaction_chapitre', ['id' => $chapitreActuel->getId()]);
    }

    return $this->render('redaction_chapitre/index.html.twig', [
        'formChapitre' => $formChapitre->createView(),
        'formTitre' => $formTitre->createView(),
        'chapitre' => $chapitreActuel,
        'histoire' => $histoire,
    ]);
}
    
    #[Route ('demande/correction/{id}', name:'app_demande_correction')]
    public function valideDemandeCorrection(HistoiresRepository $histoiresRepo, int $id):Response
    {
        $histoire=$histoiresRepo->find($id);
        
        $histoireModif=$histoiresRepo->changerStatutHistoireRvD($histoire);

         return $this->redirectToRoute('app_compte', ["id"=>$histoire->getUser()->getId()]);
    }

}
