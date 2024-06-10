<?php
namespace App\Controllers\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AuthTestController extends AbstractController
{
    public function __construct
    ()
    {
    }

    #[Route('/api/test')]
    public function getMainPage(Request $request): JsonResponse
    {
        return new JsonResponse('www');
    }
}