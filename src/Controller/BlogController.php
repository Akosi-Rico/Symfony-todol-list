<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

class BlogController extends AbstractController
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    #[Route('/blogs', name: 'app_blog')]
    public function index(Request $request,EntityManagerInterface $entityManager ): Response
    {
        $person = $entityManager->getRepository(Person::class);
        return $this->render('views/index.html.twig', [
            'persons' => $person->findAll(),
            'removeDataUrl' => $this->router->generate('remove_data'),
            'updateDataUrl' => $this->router->generate('update_or_create_data'),
        ]);
    }

    #[Route('/blogs/remove', methods:["POST"], name: 'remove_data')]
    public function removeData(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->beginTransaction();
          
            $person = $entityManager->getRepository(Person::class)->find($request->request->get("id"));
            if (empty($person)) {
                throw $this->createNotFoundException('Entity not found.');
            }

            $entityManager->remove($person);
            $entityManager->flush();

            $entityManager->commit();
            return new JsonResponse([
                "message" => "Successfully Removed!"
            ]);
        } catch(\Throwable $th) {
            $entityManager->rollback();
            return new Response($th);
        }
    }

    #[Route('/blogs/update-create', methods:["POST"], name: 'update_or_create_data')]
    public function updateData(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->beginTransaction();
            $person = $entityManager->getRepository(Person::class)->find($request->request->get("id"));
            if (empty($request->request->get("id"))) {
                $person = new Person();
            }
            $person->setName($request->request->get("name"));
            $person->setAge($request->request->get("age"));
            $person->setOccupation($request->request->get("occupation"));

            if (empty($request->request->get("id"))) {
                $entityManager->persist($person);
            }
       
            $entityManager->flush();
            $entityManager->commit();

            return new JsonResponse([
                "message" => "Transaction Successfully Completed!"
            ]);
        } catch(\Throwable $th) {
            $entityManager->rollback();
            return new Response($th);
        }
    }
}
