<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{

    #[Route('/api/login_check', name: 'api_login')]
    public function index(#[CurrentUser] ?User $user): void
    {
    }

    #[Route('/api/test', name: 'api_test')]
    public function test(): Response
    {
        return $this->render("bla-bla");
    }


}