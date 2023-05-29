<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
//    #[Route(path: '/articles', name: 'articles', methods: ['GET'])]
    /**
     * @Route("/")
     */
    public function list(): Response
    {
        return new Response('Welcome to Latte and Code ');
    }
    /**
     * @Route("/user/{id}")
     */
    public function user($id): Response
    {
        return new Response('Welcome to Latte and Code '.$id);
        }

}
