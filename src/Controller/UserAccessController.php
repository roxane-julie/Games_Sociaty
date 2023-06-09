<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAccessController extends AbstractController
{
    #[Route('/user/access', name: 'app_user_access')]
    public function index(): Response
    {
        return $this->render('user_access/index.html.twig', [
            'controller_name' => 'UserAccessController',
        ]);
    }
}
