<?php

namespace App\Controller;

use App\Entity\PieceJointe;
use App\Entity\User;
use App\Repository\MessagesRepository;
use App\Repository\PieceJointeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MessagerieController extends AbstractController
{
    #[Route('/messagerie/{id}', name: 'app_messagerie')]
    public function index(MessagesRepository $messagesRepo, int $id, PieceJointeRepository $pieceJointeRepo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $messagesRecus = $messagesRepo->findMessageRecus($id);

        $messagesEnvoyer = $messagesRepo->findMessageEnvoyer($id);

        $pieceJointeRecu = [];
        $pieceJointeEnv = [];



        return $this->render('messagerie/index.html.twig', [
            'messagesRecus' => $messagesRecus,
            'messagesEnvoyer' => $messagesEnvoyer
        ]);
    }

    #[Route('/suppresion/message/{id}', name: 'app_suppression')]
    public function suppressionMessage(MessagesRepository $messagesRepo, int $id, EntityManagerInterface $em): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $message = $messagesRepo->find($id);

        if ($message->getExpediteur() == $user) {
            $message->setAffichageExpe(false);
            $em->persist($message);
            $em->flush();
        }

        if ($message->getDestinataire() == $user) {
            $message->setAffichageDesti(false);
            $em->persist($message);
            $em->flush();
        }

        //  dd($message);

        return $this->redirectToRoute('app_messagerie', ["id" => $user->getId()]);

    }

}
