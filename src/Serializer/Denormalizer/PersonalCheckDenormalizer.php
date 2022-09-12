<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Guest;
use App\Entity\PersonalCheck;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PersonalCheckDenormalizer implements DenormalizerInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): PersonalCheck
    {
        if (key_exists('oldEntity', $context))
        {
            $personalCheck = $context['oldEntity'];
            if (key_exists('inCheck', $data))
            {
                $personalCheck->setWhoCheck($data['inCheck']);
            }
            if (key_exists('guest', $data))
            {
                $guest = $this->em->getRepository(Guest::class)->find($data['guest']['id']);
                $personalCheck->setGuest($guest);
            }
            if (key_exists('product', $data))
            {
                $product = $this->em->getRepository(Product::class)->find($data['product']['id']);
                $personalCheck->setProduct($product);
            }
            if (key_exists('amount', $data))
            {
                $personalCheck->setAmount($data['amount']);
            }
            if (key_exists('author', $data))
            {
                $personalCheck->setWhoAuthor($data['author']);
            }
        }
        else
        {
            $personalCheck = new PersonalCheck();
            $personalCheck->setWhoCheck($data['inCheck']);
            $guest = $this->em->getRepository(Guest::class)->find($data['guest']['id']);
            $personalCheck->setGuest($guest);
            $product = $this->em->getRepository(Product::class)->find($data['product']['id']);
            $personalCheck->setProduct($product);
            $personalCheck->setAmount($data['amount']);
            $personalCheck->setWhoAuthor($data['author']);
        }

        return $personalCheck;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return PersonalCheck::class == $type;

    }
}