<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'api_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository, NormalizerInterface $normalizer) :Response
    {
        return $this->json($productRepository->findAll());
    }

    #[Route('/new', name: 'api_product_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer)
    {
        $product = $serializer->deserialize($request->getContent(), Product::class, 'json');
        $entityManager->persist($product);
        $entityManager->flush();
        return $this->json($product, 201);
    }

    #[Route('/{id}', name: 'api_check_show', methods: ['GET'])]
    public function show(Product $product, ProductRepository $productRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($productRepository->find($product->getId()));
    }

    #[Route('/{id}/edit', name: 'api_product_edit', methods: ['PUT'])]
    public function edit(Product $product, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $editProduct = $serializer->deserialize($request->getContent(), Product::class, 'json', ['oldEntity' => $product]);

        $entityManager->flush();

        return $this->json($editProduct, 201);
    }

    #[Route('/{id}/delete', name: 'api_product_delete', methods: ['DELETE'])]
    public function delete(Product $product, ProductRepository $productRepository, EntityManagerInterface $entityManager): Response
    {
        if ($productRepository->find($product->getId()) == null) {
            throw new Exception('Тусовки с указанным ID не существует.');
        }

        $id = $product->getId();
        $entityManager->remove($product);
        $entityManager->flush();

        $data = [
            'id' => $id,
            'status' => 'deleted'
        ];

        return $this->json($data, 201);
    }
}