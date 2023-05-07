<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(GameRepository $repo): Response
    {
        $boardgames = $repo->findAll();
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'boardgames' => $boardgames
        ]);
    }

    #[Route('/game/add', name: 'app_add_game')]
    public function addGame(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $em = $doctrine->getManager();
        $newgame = new Game;
        $form = $this->createForm(GameType::class, $newgame)
            ->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('picture')->getData();
            
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();
                
                   // Move the file to the directory where brochures are stored
                   try {
                    $pictureFile->move(
                        $this->getParameter('game_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            $newgame->setPicture($newFilename);
            $newgame = $form->getData();

            $em->persist($newgame);
            $em->flush();
        }

            return $this->render('game/addGame.html.twig', [
                'controller_name' => 'GameController',
                'form' => $form
            ]);
        }

        #[Route('/game/{id}', name:'app_show_game')]
    public function show(GameRepository $repo, $id):Response
    {
        $game = $repo->find($id);

        return $this->render('game/show.html.twig', [
            'controller_name' => 'Game',
            'title' => $game->getTitle(),
            'game' => $game
            
        ]);
    }
    }



