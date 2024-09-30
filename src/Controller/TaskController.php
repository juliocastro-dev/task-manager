<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TaskController extends AbstractController
{
    #[Route('/api/tasks', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $tasks = $entityManager->getRepository(Task::class)->findAll();
        return $this->json($tasks);
    }

    #[Route('/api/tasks', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $data = $request->getContent();
        $task = $serializer->deserialize($data, Task::class, 'json');

        $task->setUser($this->getUser());

        $entityManager->persist($task);
        $entityManager->flush();

        return $this->json($task, JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/tasks/{id}', methods: ['PUT'])]
    public function update(Request $request, Task $task, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $data = $request->getContent();
        $serializer->deserialize($data, Task::class, 'json', ['object_to_populate' => $task]);

        $entityManager->flush();

        return $this->json($task);
    }

    #[Route('/api/tasks/{id}', methods: ['DELETE'])]
    public function delete(Task $task, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($task);
        $entityManager->flush();

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
