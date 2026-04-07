<?php

namespace App\Controller;

use App\Form\CorrectionReponseType;
use App\Form\ReponseMessageType;
use App\Repository\CorrectionsRepository;
use App\Repository\MessagesRepository;
use App\Repository\PieceJointeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReponseMessageController extends AbstractController
{
    #[Route('/reponse/message/{id}', name: 'app_reponse_message')]
    public function index(int $id, MessagesRepository $messagesRepo, CorrectionsRepository $correctionsRepo, Request $request, PieceJointeRepository $pieceJointeRepo): Response
    {
        $messageRecu = $messagesRepo->find($id);

        $reponse = $messagesRepo->creerMessage($messageRecu->getDestinataire(), $messageRecu->getExpediteur());

        $formRep = $this->createForm(ReponseMessageType::class, $reponse);
        $formRep->handleRequest($request);

        $pjRecu=$pieceJointeRepo->findPieceJointeByMessage($messageRecu);

        $pjRep=[];

        foreach ($pjRecu as $pj) {

            $pjrepTemp=$pieceJointeRepo->creerPieceJointe($reponse,$pj->getCorrection());

            array_push($pjRep,$pjrepTemp );

        } 

    //    foreach ( $pjRep as $pj){

    //     $formPj = $this->createForm(CorrectionReponseType::class,$pj );

    //    }

        

        return $this->render('reponse_message/index.html.twig', [
            "pieceJointes"=>$pjRep,
            "formRep"=>$formRep->createView()
        ]);
    }
}
