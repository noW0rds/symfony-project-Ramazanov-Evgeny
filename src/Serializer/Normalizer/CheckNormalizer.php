<?php

namespace App\Serializer\Normalizer;

use App\Entity\Check;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CheckNormalizer implements NormalizerInterface
{
    /**
     * @param Check $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|string|void|null
     */

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'date' => $object->getDate(),
            'store' => $object->getStore(),
            'buyingGuest' => $object->getBuyingGuest() ? [
                'id' => $object->getBuyingGuest()->getId(),
                'name' => $object->getBuyingGuest()->getName(),
                'number' => $object->getBuyingGuest()->getNumber(),
            ]: null,
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Check;
    }
}