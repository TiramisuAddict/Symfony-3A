<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\BookRepository;
use App\Repository\AuthorRepository;

use App\Form\BookType;
use App\Form\UpdateBookType;

use Symfony\Component\HttpFoundation\Request;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('book/list', name: 'app_book_manage_list')]
    public function booksList(BookRepository $repository){
        $books = $repository->findAll();
        return $this->render('book/manageBooks.html.twig' , [
            'books' => $books,
        ]);
    }

    //FORM : CREATE BOOK
    #[Route('book/add', name: 'app_book_form')]
    public function addBook(Request $request, ManagerRegistry $doctrine, BookRepository $repository, AuthorRepository $repository_auth) : Response{
        $book = new Book();
        $form = $this->createForm(BookType::class,$book);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em = $doctrine->getManager();

            $book = $form->getData();
            $book->setPublished(true);
            
            $id_auth = $book->getAuthorBooks()->getId();

            $author = $repository_auth->find($id_auth);
            $author->setNbBooks($author->getNbBooks()+1);

            $em->persist($author);

            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('app_book_manage_list');
        }
        
        return $this->render('book/addBook.html.twig', [
            'form' => $form, //$form->createView
        ]);
    }

    //FORM : UPDATE BOOK
    #[Route('book/update={id}', name: 'app_book_edit')]
    public function editBook($id, Request $request, ManagerRegistry $doctrine, BookRepository $repository, AuthorRepository $repository_auth){
        $book = $repository->find($id);
        $form = $this->createForm(UpdateBookType::class,$book);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $doctrine->getManager();

            $new_book = $form->getData();
            
            $book->setTitle($new_book->getTitle());
            $book->setPublicationDate($new_book->getPublicationDate());
            $book->setPublished($new_book->getPublished());
            $book->setAuthorBooks($new_book->getAuthorBooks());
            $book->setCategory($new_book->getCategory());

            $em->persist($book);
            $em->flush($book);
            
            return $this->redirectToRoute('app_book_manage_list');
        }

        return $this->render('book/addBook.html.twig' , [
            'form' => $form,
        ]);
    }

    //DELETE
    #[Route('book/delete={id}', name: 'app_book_delete')]
    public function deleteBook($id, ManagerRegistry $doctrine, BookRepository $repository ){
        $em = $doctrine->getManager();

        $book = $repository->find($id);

        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('app_book_manage_list');
    }

    //SHOW
    #[Route('book/show={id}', name: 'app_book_show')]
    public function showBook($id, ManagerRegistry $doctrine, BookRepository $repository ){
        $em = $doctrine->getManager();

        $book = $repository->find($id);

        return $this->render('book/showBook.html.twig',[
            'book' => $book,
        ]);
    }


}
