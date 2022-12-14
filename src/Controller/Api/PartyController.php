<?php

namespace App\Controller\Api;

use App\Entity\Party;
use App\Repository\PartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/party')]
class PartyController extends AbstractController
{
    #[Route('/', name: 'api_party_index', methods: ['GET'])]
    public function index(PartyRepository $partyRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($partyRepository->findAll());
    }

    #[Route('/new', name: 'api_party_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer)
    {
        $party = $serializer->deserialize($request->getContent(), Party::class, 'json');
        $entityManager->persist($party);
        $entityManager->flush();
        return $this->json($party, 201);
    }

    #[Route('/{id}', name: 'api_party_show', methods: ['GET'])]
    public function show(Party $party, PartyRepository $partyRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($partyRepository->find($party->getId()));
    }

    #[Route('/{id}/edit', name: 'api_party_edit', methods: ['PUT'])]
    public function edit(Party $party, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $editParty = $serializer->deserialize($request->getContent(), Party::class, 'json', ['oldEntity' => $party]);

        $entityManager->flush();

        return $this->json($editParty, 201);
    }

    #[Route('/{id}/delete', name: 'api_party_delete', methods: ['DELETE'])]
    public function delete(Party $party, PartyRepository $partyRepository, EntityManagerInterface $entityManager): Response
    {
        if ($partyRepository->find($party->getId()) == null) {
            throw new Exception('?????????????? ?? ?????????????????? ID ???? ????????????????????.');
        }

        $id = $party->getId();
        $entityManager->remove($party);
        $entityManager->flush();

        $data = [
            'id' => $id,
            'status' => 'deleted'
        ];

        return $this->json($data, 201);
    }
}