<?php

namespace App\Controller;

use App\Repository\MessagesRepository;
use App\Repository\PieceJointeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DetailMessageController extends AbstractController
{
    #[Route('/detail/message/{id}', name: 'app_detail_message')]
    public function index(int $id, MessagesRepository $messagesRepo, PieceJointeRepository $pieceJointeRepo): Response
    {   
        $message=$messagesRepo->find($id);

        $pieceJointes=$pieceJointeRepo->findPieceJointeByMessage($message);

        return $this->render('detail_message/index.html.twig', [
            'message'=>$message,
            'pieceJointes'=>$pieceJointes
        ]);
    }
}
