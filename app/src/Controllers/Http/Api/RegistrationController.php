<?php

namespace App\Controllers\Http\Api\Registration;

use App\Modules\User\Infrastructure\Readers\RegisterUserReader;
use App\Modules\User\Infrastructure\API\IRegisterUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{

    public function __construct (
        private readonly IRegisterUserService $registerUserService,
        private readonly RegisterUserReader   $registerUserReader,
        private readonly Security $security,
    ){}

    #[Route('/api/registration')]
    public function index(Request $request): Response
    {
        $user = $this->security->getUser();
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