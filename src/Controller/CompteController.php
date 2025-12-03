<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CompteType;
use Symfony\Component\HttpFoundation\Request;

final class CompteController extends AbstractController
{
    #[Route('/compte/{id}', name: 'app_compte')]
    public function index(Request $request): Response
    {   
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

         /**
         * @var User $user
         */

        $user= $this->getUser();

        $form=$this->createForm(CompteType::class, $user,['email'=>$user->getEmail(), 'username'=>$user->getUsername()]);

        $form->handleRequest($request);
        
        return $this->render('compte/index.html.twig', [
            'controller_name' => 'CompteController',
            'form' =>$form->createView()
        ]);
    }
}
