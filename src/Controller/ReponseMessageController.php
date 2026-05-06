<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CorrectionReponseType;
use App\Form\ReponseMessageType;
use App\Repository\CorrectionsRepository;
use App\Repository\MessagesRepository;
use App\Repository\PieceJointeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReponseMessageController extends AbstractController
{
    #[Route('/reponse/message/{id}', name: 'app_reponse_message')]
    public function index(
        int $id, 
        MessagesRepository $messagesRepo,  
        Request $request, 
        PieceJointeRepository $pieceJointeRepo, 
        EntityManagerInterface $em): Response
    {
        $messageRecu = $messagesRepo->find($id);

        $reponse = $messagesRepo->creerMessage($messageRecu->getDestinataire(), $messageRecu->getExpediteur());

        $formRep = $this->createForm(ReponseMessageType::class, $reponse);
        $formRep->handleRequest($request);

        $pjRecu = $pieceJointeRepo->findPieceJointeByMessage($messageRecu);

        $pjRep = [];


        foreach ($pjRecu as $pj) {

            $pjrepTemp = $pieceJointeRepo->creerPieceJointe($reponse, $pj->getCorrection());

            array_push($pjRep, $pjrepTemp);

        }

        $expe= $reponse->getExpediteur();

        if ($formRep->isSubmitted() && $formRep->isValid()) {
            $reponse->setContenu($formRep->get('contenu')->getData());
            $reponse->setObjet($formRep->get('objet')->getData());
            $reponse->setEnvoyer(true);
            $reponse->setDateEnvoi(new DateTime());
            $em->persist($reponse);
            $em->flush();

            return $this->redirectToRoute('app_messagerie', ["id" => $expe->getId()]);
        }

        return $this->render('reponse_message/index.html.twig', [
            "pieceJointes" => $pjRep,
            "formRep" => $formRep->createView()
        ]);
    }
}
