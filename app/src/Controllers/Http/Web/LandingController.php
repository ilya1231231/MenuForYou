<?php

namespace App\Controllers\Http\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LandingController extends AbstractController
{

    public function __construct()
    {
    }

    #[Route('/')]
    public function getMainPage(Request $request): Response
    {
        $g = 1;
        return $this->render('landing/main_page.html.twig');
    }
}