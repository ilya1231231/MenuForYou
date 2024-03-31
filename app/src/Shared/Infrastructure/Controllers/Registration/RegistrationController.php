<?php

namespace App\Shared\Infrastructure\Controllers\Registration;

use App\User\Infrastructure\Dbal\Entity\User;
use App\User\Application\Ports\IRegisterUserPort;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    private IRegisterUserPort $registerUserPort;

    public function __construct (
        IRegisterUserPort $registerUserPort,
    ){
        $this->registerUserPort = $registerUserPort;
    }

    #[Route('/registration')]
    public function index(Request $request): Response
    {
        return $this->render('registration/registration.html.twig');
    }

    #[Route('/register')]
    public function register(Request $request): Response
    {
        /*
         * чтение из реквеста
         * Маппинг на ДТО
         * маппинг на ентити DDD
         * маппинг на ентити doctrine
         * сохраниение
         * */
        $user = new User();
        $user->setEmail(random_int(1, 999999) . "@mail.ru");
        $user->setPassword(random_int(1, 999999) . "@mail.ru");

        $id = $this->registerUserPort->register($user);
        return new Response('Saved new product with id ' . $id);
    }
}