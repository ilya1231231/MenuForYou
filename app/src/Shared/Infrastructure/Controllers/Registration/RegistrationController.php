<?php

namespace App\Shared\Infrastructure\Controllers\Registration;

use App\Shared\Infrastructure\SPI\User\Registration\IRegisterUserReader;
use App\Shared\Infrastructure\SPI\User\Registration\IRegisterUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    private IRegisterUserService $registerUserService;
    private IRegisterUserReader $registerUserReader;

    public function __construct (
        IRegisterUserService $registerUserService,
        IRegisterUserReader $registerUserReader,
    ){
        $this->registerUserService = $registerUserService;
        $this->registerUserReader = $registerUserReader;
    }

    #[Route('/registration')]
    public function index(Request $request): Response
    {
        return $this->render('registration/registration.html.twig');
    }

    #[Route('/register')]
    public function registerJson(Request $request): Response
    {
        $rawData = $request->getContent();
        $dto = $this->registerUserReader->readJson($rawData);
        $id = $this->registerUserService->register($dto);
        return new Response('Saved new product with id ' . $id);
    }
}