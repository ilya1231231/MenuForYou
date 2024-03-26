<?php
namespace App\Shared\Infrastructure\Controllers\Auth;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration')]
    public function index(Request $request): Response
    {
        return $this->render('@registration/index.html.twig');
    }

    #[Route('/register')]
    public function register(Request $request): Response
    {
        return $this->render('@registration/index.html.twig');
    }
}