<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

class BlogController extends AbstractController
{
    #[Route('/blogs', name: 'app_blog')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $person = $entityManager->getRepository(Person::class);
        return $this->render('views/index.html.twig', [
            'persons' => $person->findAll(),
        ]);
    }
}
