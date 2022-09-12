<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Check;
use App\Entity\Guest;
use App\Entity\Product;
use App\Entity\User;
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

class GuestDenormalizer implements DenormalizerInterface
{


    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Guest
    {
        if (key_exists('oldEntity', $context))
        {
            $guest = $context['oldEntity'];
            if (key_exists('name', $data))
            {
                $guest->setName($data['name']);
            }
            if (key_exists('number', $data))
            {
                $guest->setNumber($data['number']);
            }
            if (key_exists('user', $data))
            {
                $user = $this->em->getRepository(User::class)->find($data['user']['id']);
                $guest->setWhoUser($user);
            }
            if (key_exists('products', $data))
            {
                $guest->setNumber($data['number']);
            }
        }
        else
        {
            $user = $this->em->getRepository(User::class)->find($data['user']['id']);
            $guest = new Guest();
            $guest->setName($data['name']);
            $guest->setNumber($data['number']);
            $guest->setWhoUser($user['user']);

            $products = $data['products'];

            foreach ($products as $prod){
                $newProd = new Product();
                $newProd->setName($prod['name']);
                $newProd->setPrice($prod['price']);
                $guest->addBuyingProduct($newProd);
            }
        }
        return $guest;


    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return Guest::class == $type;

    }
}