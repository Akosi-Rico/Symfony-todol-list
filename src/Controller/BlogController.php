<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
    #[Route('/blogs', name: 'app_blog')]
    public function index(): Response
    {
        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/BlogController.php',
        // ]);
        $number = random_int(0, 100);
        return $this->render('views/index.html.twig', [
            'number' => 1,
        ]);
    }
}
