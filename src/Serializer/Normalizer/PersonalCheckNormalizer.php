<?php

namespace App\Serializer\Normalizer;

use App\Entity\PersonalCheck;
use App\Entity\Product;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PersonalCheckNormalizer implements NormalizerInterface
{
    /**
     * @param PersonalCheck $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = [
            'id' => $object->getId(),
            'checks' => $object->getWhoCheck() ? [
                'id' => $object->getWhoCheck()->getId(),
                'store' => $object->getWhoCheck()->getStore(),
            ] : null,
            'product' => $object->getProduct() ? [
                'id' => $object->getProduct()->getId(),
                'name' => $object->getProduct()->getName(),
                'price' => $object->getProduct()->getPrice(),
            ] : null,
            'amount' => $object->getAmount(),
            'guest' => $object->getGuest() ? [
                'id' => $object->getGuest()->getId(),
                'name' => $object->getGuest()->getName(),
                'number' => $object->getGuest()->getNumber(),
            ] : null,
        ];

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof PersonalCheck;
    }
}