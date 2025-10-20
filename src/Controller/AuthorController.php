<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AuthorRepository;

use App\Form\AuthorType;
use Symfony\Component\HttpFoundation\Request;

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

    /*#[Route('author/list', name: 'app_author_list')]
    public function listAuthors(){

        return $this->render('author/list.html.twig' , [
            'authors' => $this->authors,
        ]);
    }*/

    //MANAGE AUTHORS PAGE
    #[Route('author/list', name: 'app_author_manage_list')]
    public function manageAuthorList(AuthorRepository $auth_repository){
        $authors = $auth_repository->findAll();
        return $this->render('author/manageAuthors.html.twig' , [
            'authors' => $authors,
        ]);
    }

    //FORM : CREATE AUTHOR
    #[Route('author/form/add', name: 'app_author_form')]
    public function addForm(Request $request, ManagerRegistry $doctrine) : Response{
        $author = new Author();
        $form = $this->createForm(AuthorType::class,$author);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $author = $form->getData();
            
            $em = $doctrine->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('app_author_manage_list');
        }
        
        return $this->render('author/addAuthor.html.twig', [ 
            'form' => $form, //$form->createView
        ]);
    }

    //FORM : UPDATE AUTHOR
    #[Route('author/form/update={id}', name:'app_author_update')]
    public function updateAuthor(Request $request, ManagerRegistry $doctrine , AuthorRepository $repository , $id): Response{
        $author = $repository->find($id);
        $form = $this->createForm(AuthorType::class,$author);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $doctrine->getManager();

            $new_author = $form->getData();

            $obj = $author;
            $obj->setUsername($new_author->getUsername());
            $obj->setEmail($new_author->getEmail());

            $em->persist($obj);
            $em->flush();
            
            return $this->redirectToRoute('app_author_manage_list');
        }

        return $this->render('author/addAuthor.html.twig', [ //For future me : I used the same form don't panic
            'form' => $form, //$form->createView
        ]);
    }

    //DELETE
    #[Route('author/removeAuthor/{id}', name: 'app_author_remove')]
    public function removeAuthor(ManagerRegistry $doctrine , AuthorRepository $auth_repository, $id): Response{
        $em = $doctrine->getManager();
        
        $obj = $auth_repository->find($id);
        $em->remove($obj);
        $em->flush();

        return $this->redirectToRoute('app_author_manage_list');
    }

    //DELETE AUTHORS WITHOUT BOOKS (NBRBOOKS = 0)
    #[Route('author/clearAuthors', name: 'app_author_clear')]
    public function removeAuthorWithoutBooks(ManagerRegistry $doctrine , AuthorRepository $auth_repository): Response{
        $em = $doctrine->getManager();
        
        $authors = $auth_repository->findAll();
        foreach ($authors as $author){
            if($author->getNbBooks() == 0){
                $em->remove($author);
                $em->flush();
            }
        }

        return $this->redirectToRoute('app_author_manage_list');
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
