<?php

namespace App\Controller;

use App\Form\PrepaMessagesType;
use App\Repository\CorrectionsRepository;
use App\Repository\HistoiresRepository;
use App\Repository\MessagesRepository;
use App\Repository\PieceJointeRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Entity\Chapitres;
use App\Entity\Histoires;

final class EnvoiMessageController extends AbstractController
{
    #[Route('/envoi/message/{id}/{IdHistoire}', name: 'app_envoi_message')]
    public function index(
        Request $request,
        int $id,
        MessagesRepository $messagesRepo,
        HistoiresRepository $histoiresRepo,
        int $IdHistoire,
        EntityManagerInterface $em
    ): Response {

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

        $histoire = $histoiresRepo->find($IdHistoire);// à supprimer ?

        $form = $this->createForm(PrepaMessagesType::class);
        $form->handleRequest($request);
        $expediteur = $this->getUser();// à supprimer ?
        $destinataire = $histoire->getUser();// à supprimer ?
        $message = $messagesRepo->find($id);
        $user = $message->getExpediteur();


        if ($form->isSubmitted() && $form->isValid()) {
            $message->setContenu($form->get('contenu')->getData());
            $message->setObjet($form->get('objet')->getData());
            $message->setEnvoyer(true);
            $message->setDateEnvoi(new DateTime('now', new DateTimeZone('Europe/Paris')));
            $em->persist($message);
            $em->flush();
            
            return $this->redirectToRoute('app_messagerie', ["id" => $user->getId()]);
        }

        return $this->render('envoi_message/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/creation/message/{id}', name: 'app_creation_message')]
    public function creationMessage(int $id, MessagesRepository $messagesRepo, CorrectionsRepository $correctionsRepo, PieceJointeRepository $pieceJointeRepo)
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

        $correction = $correctionsRepo->find($id);
        $histoire = $correction->getHistoire();
        $expediteur = $this->getUser();
        $destinataire = $histoire->getUser();
        $message = $messagesRepo->creerMessage($expediteur, $destinataire);

        //creation des pieces jointes avec les corrections lié à l'histoire
        $tabCorrec = $correctionsRepo->findCorrectionsByHistoire($histoire->getId());
        foreach ($tabCorrec as $correc) {
            $pieceJointeRepo->creerPieceJointe($message, $correc);
        }

        return $this->redirectToRoute("app_envoi_message", ["id" => $message->getId(), "IdHistoire" => $histoire->getId()]);

    }
    
}
