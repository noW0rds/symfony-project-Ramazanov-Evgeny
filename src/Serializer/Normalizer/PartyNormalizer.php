<?php

namespace App\Serializer\Normalizer;

use App\Entity\Party;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PartyNormalizer implements NormalizerInterface
{
    /**
     * @param Party $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|string|void|null
     */

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'date' => $object->getDateAt(),
            'location' => $object->getLocation(),
            'guests' => $object->getPartyGuests()->toArray(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Party;
    }
}