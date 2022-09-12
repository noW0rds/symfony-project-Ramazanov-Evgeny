<?php

namespace App\Serializer\Normalizer;

use App\Entity\Product;
use ArrayObject;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductNormalizer implements NormalizerInterface
{
    /**
     * @param Product $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|string|void|null
     */

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
       return [
           'id' => $object->getId(),
           'name' => $object->getName(),
           'price' => $object->getPrice(),
       ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Product;
    }
}