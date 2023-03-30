<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie', name: 'app_movie')]
    public function index(MovieRepository $repo): Response
    {
        $posts= $repo->findAll();
        return $this->render('movie/index.html.twig',compact('posts'));  
    }

    #[Route('/post/{id}',name: 'app_showmovie')]
    public function show($id,MovieRepository $repo): Response
    {
        //je recupere le poste avec l'id
        $post = $repo->find($id);
        //je passe à la vue
        return $this->render('movie/showmovie.html.twig', compact('post'));
    }

} 
