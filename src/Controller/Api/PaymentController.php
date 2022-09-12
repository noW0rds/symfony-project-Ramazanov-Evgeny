<?php

namespace App\Controller\Api;

use App\Entity\Payment;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/payment')]
class PaymentController extends AbstractController
{
    #[Route('/', name: 'api_payment_index', methods: ['GET'])]
    public function index(PaymentRepository $paymentRepository, NormalizerInterface $normalizer) :Response
    {
        return $this->json($paymentRepository->findAll());
    }

    #[Route('/new', name: 'api_payment_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer)
    {
        $payment = $serializer->deserialize($request->getContent(), Payment::class, 'json');
        $entityManager->persist($payment);
        $entityManager->flush();
        return $this->json($payment, 201);
    }

    #[Route('/{id}', name: 'api_payment_show', methods: ['GET'])]
    public function show(Payment $payment, PaymentRepository $paymentRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($paymentRepository->find($payment->getId()));
    }

    #[Route('/{id}/edit', name: 'api_payment_edit', methods: ['PUT'])]
    public function edit(Payment $payment, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $editPayment = $serializer->deserialize($request->getContent(), Payment::class, 'json', ['oldEntity' => $payment]);

        $entityManager->flush();

        return $this->json($editPayment, 201);
    }

    #[Route('/{id}/delete', name: 'api_payment_delete', methods: ['DELETE'])]
    public function delete(Payment $payment, PaymentRepository $paymentRepository, EntityManagerInterface $entityManager): Response
    {
        if ($paymentRepository->find($payment->getId()) == null) {
            throw new Exception('Платежа с указанным ID не существует.');
        }

        $id = $payment->getId();
        $entityManager->remove($payment);
        $entityManager->flush();

        $data = [
            'id' => $id,
            'status' => 'deleted'
        ];

        return $this->json($data, 201);
    }
}