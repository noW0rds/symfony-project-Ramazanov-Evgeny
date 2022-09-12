<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Check;
use App\Entity\Guest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CheckDenormalizer implements DenormalizerInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (key_exists('oldEntity', $context))
        {
            $check = $context['oldEntity'];
            if (key_exists('date', $data))
            {
                $check->setDate(new \DateTimeImmutable($data['date']));
            }
            if (key_exists('store', $data))
            {
                $check->setStore($data['store']);
            }
            if (key_exists('guest', $data))
            {
                $guest = $this->em->getRepository(Guest::class)->find($data['guest']['id']);
                $check->setBuyingGuest($guest);
            }
        }
        else
        {
            $check = new Check();
            $check->setDate(new \DateTimeImmutable($data['date']));
            $check->setStore($data['store']);
            $guest = $this->em->getRepository(Guest::class)->find($data['guest']['id']);
            $check->setBuyingGuest($guest);
        }
        return $check;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Check::class == $type;
    }
}