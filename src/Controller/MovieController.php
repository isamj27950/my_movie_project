<?php

namespace App\Controller;

use App\Entity\Movie;
use DateTimeImmutable;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
    
    #[Route('/create', name: 'app_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        // cree nouvel objet
        $movie = new Movie;

        // cree form
        $form = $this->createForm(MovieFormType::class, $movie);
        // $showForm = $form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPost = $form->getData();

            $imagePath = $form->get('image')->getdata();

            if ($imagePath) {

                $newFileName = uniqid() . '.' . $imagePath->guessExtension();
                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/upload',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newPost->setimage('/upload/' . $newFileName);
            }
            // set le champ created_at avec la date de l'envoi du formulaire
            //$newPost->setCreatedAt(new DateTimeImmutable());
            // persiste les datas de user
            $em->persist($newPost);
            $em->flush();
            // redirection
            return $this->redirectToRoute('app_movie');
        }


        return $this->render('movie/create.html.twig', ['showForm' => $form->createView()]);
    }   

    #[Route('/movie/delete/{id}', name: 'app_delete', methods: ['GET', 'DELETE'])]
    public function delete($id, MovieRepository $repo, EntityManagerInterface $em): Response
    {
        $movie = $repo->find($id);

        $em->remove($movie);

        $em->flush();

        return $this->redirectToRoute('app_movie');
    }

    #[Route('/update/{id}',name: 'app_update', methods: ['GET','POST'])]
    public function update($id, MovieRepository $repo, Request $request, EntityManagerInterface $em): Response
    {
        //1-Je recuperre le post avec l'id
        $post = $repo->find($id);
        //2-create form + prés rempli le formulaire avec $post
        $form = $this->createForm(MovieFormType::class,$post);
        //Ajouter en bdd
        //1-recupere data de mes input
        $form->handleRequest($request);
        //recupere l'url de l'ima enBDD
        $imagePath = $form->get('image')->getData();
        //2-soumision du formulaire
        if($form->isSubmitted() && $form->isValid()){
            //verifie si une img a ete choisi
            if($imagePath){
                //on vérifie que l'image existe ds la db
                if($post->getImage() !== null ){
                    //renomme l'image qu'il a choisit
                    $newFileName = uniqid(). '.' . $imagePath->guessExtension();
                    //donne a l'image un new name    
                    try {
                    //deplacer l'image dans le dossier public/upload
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/upload',
                        $newFileName
                    );
                    }catch (FileException $e) {
                        return new Response($e->getMessage());
                    }
                    //je modifie l'urlimag ds $post
                    $post->setImage('/upload/'. $newFileName);
                    $em->flush();
                    return $this->redirectToRoute('app_movie');
                } else {
                    $post->setImage($form->get('image')->getData());
                    $em->flush();
                    return $this->redirectToRoute('app_movie');
                }
            }
            //recupere lesdata user s'il modifie ou non
            
            //$post->setUpdatedAt(new DateTimeImmutable());
            $em->flush();
            return $this->redirectToRoute('app_movie');
        }
        //3-envoie du formulaire ds la vue
        return $this->render('movie/update.html.twig',[
            'showForm' => $form->createView()
        ]);
    }
} 
