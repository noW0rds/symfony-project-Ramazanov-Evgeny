<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Guest;
use App\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PaymentDenormalizer implements DenormalizerInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {

    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (key_exists('oldEntity', $context))
        {
            $payment = $context['oldEntity'];
            if (key_exists('date', $data))
            {
                $payment->setDate($data['name']);
            }
            if (key_exists('cost', $data))
            {
                $payment->setCost($data['cost']);
            }
            if (key_exists('from', $data))
            {
                $payment->setFromGuest($this->em->getRepository(Guest::class)->find($data['from']['id']));
            }
            if (key_exists('to', $data))
            {
                $payment->setToGuest($this->em->getRepository(Guest::class)->find($data['to']['id']));
            }
        }
        else
        {
            $payment = new Payment();

            $payment->setDate(new \DateTimeImmutable($data['date']));
            $payment->setCost($data['cost']);
            $payment->setFromGuest($this->em->getRepository(Guest::class)->find($data['from']['id']));
            $payment->setToGuest($this->em->getRepository(Guest::class)->find($data['to']['id']));
        }
        return $payment;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Payment::class == $type;
    }
}