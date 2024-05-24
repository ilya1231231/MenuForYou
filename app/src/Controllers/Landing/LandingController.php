<?php
namespace App\Controllers\Landing;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LandingController extends AbstractController
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    #[Route('/')]
    public function getMainPage(Request $request): Response
    {
        $d = 2;
        if ($d) {
            throw new \Exception('wwwwwww');
        }
        return $this->render('landing/main_page.html.twig');
    }
}