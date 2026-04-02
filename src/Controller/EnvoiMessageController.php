<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EnvoiMessageController extends AbstractController
{
    #[Route('/envoi/message/{id}', name: 'app_envoi_message')]
    public function index(): Response
    {
        return $this->render('envoi_message/index.html.twig', [
            
        ]);
    }
}
