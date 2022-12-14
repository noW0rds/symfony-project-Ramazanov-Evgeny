<?php

namespace App\Serializer\Normalizer;

use App\Entity\Guest;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GuestNormalizer implements NormalizerInterface
{
    /**
     * @param Guest $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|string|void|null
     */

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'number' => $object->getNumber(),
            'user' => $object->getWhoUser() ? [
                'id' => $object->getWhoUser()->getId(),
                'email' => $object->getWhoUser()->getEmail(),
            ]: null,
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Guest;
    }
}