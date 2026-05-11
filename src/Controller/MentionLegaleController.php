<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MentionLegaleController extends AbstractController
{
    #[Route('/mention/legale', name: 'app_mention_legale')]
    public function index(): Response
    {
        return $this->render('mention_legale/index.html.twig', [
           
        ]);
    }
}
