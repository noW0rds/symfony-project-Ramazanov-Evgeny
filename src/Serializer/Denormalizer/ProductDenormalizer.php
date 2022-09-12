<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Product;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProductDenormalizer implements DenormalizerInterface
{

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (key_exists('oldEntity', $context))
        {
            $product = $context['oldEntity'];
            if (key_exists('name', $data))
            {
                $product->setName($data['name']);
            }
            if (key_exists('price', $data))
            {
                $product->setPrice($data['price']);
            }
        }
        else
        {
            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);
        }
        return $product;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Product::class == $type;
    }
}