<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    private $authors = array(
            array(
                'id' => 1,
                'picture' => '/images/Victor-Hugo.jpg',
                'username' => 'Victor Hugo',
                'email' => 'victor.hugo@gmail.com',
                'nb_books' => 100
            ),
            array(
                'id' => 2,
                'picture' => '/images/william-shakespeare.jpg',
                'username' => 'William Shakespeare',
                'email' => 'william.shakespeare@gmail.com',
                'nb_books' => 200
            ),
            array(
                'id' => 3,
                'picture' => '/images/Taha_Hussein.jpg',
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com',
                'nb_books' => 300
            )
        );

    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('author/list', name: 'lapp_author_list')]
    public function listAuthors(){

        return $this->render('author/list.html.twig' , [
            'authors' => $this->authors,
        ]);
    }

    #[Route('author/details={id}', name: 'app_author_details')]
    public function authorDetails($id) : Response
    {
        foreach ($this->authors as $author){
            if ($author['id'] == $id) {
                $desired_author = $author;
                break;
            }
        }

        return $this->render('author/showAuthor.html.twig', [
            'id' => $id,
            'author' => $desired_author,
        ]);
    }

    #[Route('author/{name}', name: 'app_author_show')]
    public function showAuthor(string $name): Response
    {
        return $this->render('author/show.html.twig', [
            'author_name' => $name,
        ]);
    }
}
