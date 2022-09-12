<?php

namespace App\Controller\Api;

use App\Entity\PersonalCheck;
use App\Repository\PersonalCheckRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/personalCheck')]
class PersonalCheckController extends AbstractController
{
    #[Route('/', name: 'api_personalCheck_index', methods: ['GET'])]
    public function index(PersonalCheckRepository $personalCheckRepository, NormalizerInterface $normalizer) :Response
    {
        $personalChecks = $personalCheckRepository->findAll();
        return $this->json($personalChecks);
    }

    #[Route('/new', name: 'api_personalCheck_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer)
    {
        $personalCheck = $serializer->deserialize($request->getContent(), PersonalCheck::class, 'json');
        $entityManager->persist($personalCheck);
        $entityManager->flush();
        return $this->json($personalCheck, 201);
    }

    #[Route('/{id}', name: 'api_personalCheck_show', methods: ['GET'])]
    public function show(PersonalCheck $personalCheck, PersonalCheckRepository $personalCheckRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($personalCheckRepository->find($personalCheck->getId()));
    }

    #[Route('/{id}/edit', name: 'api_personalCheck_edit', methods: ['PUT'])]
    public function edit(PersonalCheck $personalCheck, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $editPersonalCheck = $serializer->deserialize($request->getContent(), PersonalCheck::class, 'json', ['oldEntity' => $personalCheck]);

        $entityManager->flush();

        return $this->json($editPersonalCheck, 201);
    }

    #[Route('/{id}/delete', name: 'api_personalCheck_delete', methods: ['DELETE'])]
    public function delete(PersonalCheck $personalCheck, PersonalCheckRepository $personalCheckRepository, EntityManagerInterface $entityManager): Response
    {
        if ($personalCheckRepository->find($personalCheck->getId()) == null) {
            throw new Exception('Личного чека с указанным ID не существует.');
        }

        $id = $personalCheck->getId();
        $entityManager->remove($personalCheck);
        $entityManager->flush();

        $data = [
            'id' => $id,
            'status' => 'deleted'
        ];

        return $this->json($data, 201);
    }
}