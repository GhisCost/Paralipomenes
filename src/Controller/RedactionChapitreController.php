<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RedactionChapitreController extends AbstractController
{
    #[Route('/redaction/chapitre', name: 'app_redaction_chapitre')]
    public function index(): Response
    {
        return $this->render('redaction_chapitre/index.html.twig', [
            'controller_name' => 'RedactionChapitreController',
        ]);
    }
}
