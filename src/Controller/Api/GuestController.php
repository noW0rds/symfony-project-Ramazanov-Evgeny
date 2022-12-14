<?php

namespace App\Controller\Api;

use App\Entity\Guest;
use App\Repository\GuestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/guest')]
class GuestController extends AbstractController
{
    #[Route('/', name: 'api_guest_index', methods: ['GET'])]
    public function index(GuestRepository $guestRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($guestRepository->findAll());
    }

    #[Route('/new', name: 'api_guest_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer)
    {
        $guest = $serializer->deserialize($request->getContent(), Guest::class, 'json');
        $entityManager->persist($guest);
        $entityManager->flush();
        return $this->json($guest, 201);
    }

    #[Route('/{id}', name: 'api_guest_show', methods: ['GET'])]
    public function show(Guest $guest, GuestRepository $guestRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($guestRepository->find($guest->getId()));
    }

    #[Route('/{id}/edit', name: 'api_guest_edit', methods: ['PUT'])]
    public function edit(Guest $guest, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $editGuest = $serializer->deserialize($request->getContent(), Guest::class, 'json', ['oldEntity' => $guest]);

        $entityManager->flush();

        return $this->json($editGuest, 201);
    }

    #[Route('/{id}/delete', name: 'api_guest_delete', methods: ['DELETE'])]
    public function delete(Guest $guest, GuestRepository $checkRepository, EntityManagerInterface $entityManager): Response
    {
        if ($checkRepository->find($guest->getId()) == null) {
            throw new Exception('?????????? ?? ?????????????????? ID ???? ????????????????????.');
        }

        $id = $guest->getId();
        $entityManager->remove($guest);
        $entityManager->flush();

        $data = [
            'id' => $id,
            'status' => 'deleted'
        ];

        return $this->json($data, 201);
    }
}