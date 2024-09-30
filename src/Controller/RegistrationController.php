<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = $request->getContent();
        $user = $serializer->deserialize($data, User::class, 'json');
        
        $user->setEmail($user->getUsername());
        
        $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());

        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['status' => 'User created'], JsonResponse::HTTP_CREATED);
    }
}