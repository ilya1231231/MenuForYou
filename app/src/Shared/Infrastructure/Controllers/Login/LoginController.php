<?php
namespace App\Shared\Infrastructure\Controllers\Login;

use App\Shared\Infrastructure\SPI\User\Login\ILoginUserReader;
use App\Shared\Infrastructure\SPI\User\Login\ILoginUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    private ILoginUserService $loginUserService;
    private ILoginUserReader $loginUserReader;
    private AuthenticationUtils $authenticationUtils;

    public function __construct (
        ILoginUserService $loginUserService,
        ILoginUserReader $loginUserReader,
        AuthenticationUtils $authenticationUtils,
    ){
        $this->loginUserService = $loginUserService;
        $this->loginUserReader = $loginUserReader;
        $this->authenticationUtils = $authenticationUtils;
    }

    #[Route('/login', name: 'app_login')]
    public function index(Request $request): Response
    {
        $err = $this->authenticationUtils->getLastAuthenticationError();
        $lastUserName = $this->authenticationUtils->getLastUsername();
        $data = [
            'err' => $err,
            'last_username' => $lastUserName,
        ];
        return $this->render('login/index.html.twig', $data);
    }

    #[Route('/loginJson')]
    public function loginJson(Request $request): Response
    {
        $rawData = $request->getContent();
        $dto = $this->loginUserReader->readJson($rawData);
        $id = $this->loginUserService->login($dto);
        return new Response('Saved new product with id ' . $id);
    }
}