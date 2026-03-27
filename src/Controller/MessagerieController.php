<?php

namespace App\Controller;

use App\Repository\MessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MessagerieController extends AbstractController
{
    #[Route('/messagerie/{id}', name: 'app_messagerie')]
    public function index(MessagesRepository $messagesRepo, int $id): Response
    {   
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $messagesRecus= $messagesRepo->findMessageRecus($id);

        $messagesEnvoyer= $messagesRepo->findMessageEnvoyer($id);

        return $this->render('messagerie/index.html.twig', [
            'messagesRecus'=> $messagesRecus,
            'messagesEnvoyer'=> $messagesEnvoyer 
        ]);
    }
}
