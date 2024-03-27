<?php

namespace App\Shared\Infrastructure\Controllers\Auth;

use App\User\Infrastructure\Dbal\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct (
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
    ){
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/registration')]
    public function index(Request $request): Response
    {
        return $this->render('@registration/index.html.twig');
    }

    #[Route('/register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $user->setEmail("124@mail.ru");
        $hashedPassword = $this->passwordHasher->hashPassword($user, '1234');
        $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return new Response('Saved new product with id ' . $user->getId());
    }
}