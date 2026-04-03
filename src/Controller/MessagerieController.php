<?php

namespace App\Controller;

use App\Entity\PieceJointe;
use App\Repository\MessagesRepository;
use App\Repository\PieceJointeRepository;
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
        foreach ($messagesRecus as $messRe) {

            array_push($pieceJointeRecu, $pieceJointeRepo->findPieceJointeByMessage($messRe));

        }

        foreach ($messagesEnvoyer as $messEnv) {

            array_push($pieceJointeEnv, $pieceJointeRepo->findPieceJointeByMessage($messEnv));

        }

        return $this->render('messagerie/index.html.twig', [
            'messagesRecus' => $messagesRecus,
            'messagesEnvoyer' => $messagesEnvoyer,
            'pieceRecu'=>$pieceJointeRecu,
            'pieceEnv'=>$pieceJointeEnv
        ]);
    }
}
