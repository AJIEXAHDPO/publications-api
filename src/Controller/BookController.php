<?php

namespace App\Controller;

use App\Entity\Book;
use App\Request\BookCreateRequest;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book', methods: ['get'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $books = $doctrine->getRepository(Book::class)->findAll();
        $booksAll = [];
        foreach ($books as $book) {
            array_push($booksAll, $book->getAll());
        }

        return $this->json([
            'books' => $booksAll,
        ]);
    }

    #[Route('/book', name: 'create_book', methods: ['post'])]
    public function create(ManagerRegistry $doctrine, #[MapRequestPayload] BookCreateRequest $request): JsonResponse
    {
        
        return $this->json([
            "Created!!!"
        ], status: 201);
    }

    #[Route('/book/{id}', name: 'delete_book', methods: ['delete'])]
    public function remove(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $book = $doctrine->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(["Not found"], status: 404);
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json([
            "deleted successfully"
        ], status: 204);
    }
}
