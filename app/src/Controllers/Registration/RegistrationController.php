<?php

namespace App\Controllers\Registration;

use App\Modules\User\Infrastructure\Readers\RegisterUserReader;
use App\Modules\User\Infrastructure\API\IRegisterUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    private IRegisterUserService $registerUserService;
    private RegisterUserReader $registerUserReader;

    public function __construct (
        IRegisterUserService $registerUserService,
        RegisterUserReader $registerUserReader,
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
    public function register(Request $request): Response
    {
        $rawData = $request->getContent();
        $dto = $this->registerUserReader->readJson($rawData);
        $id = $this->registerUserService->register($dto);
        return new JsonResponse(['id' => $id]);
    }
}