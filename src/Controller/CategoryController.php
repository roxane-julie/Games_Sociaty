<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/category/new', name: 'app_add_category')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $newcat = new Category();
        $form = $this->createForm(CategoryType::class, $newcat)
        -> add('enregistrer',SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $newcat = $form->getData();
            
            $em->persist($newcat);
            $em->flush();
        }
        
        return $this->render('category/add.html.twig', [
            'form'=>$form
        ]);
    }
}
