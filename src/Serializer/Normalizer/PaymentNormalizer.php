<?php

namespace App\Serializer\Normalizer;

use App\Entity\Payment;
use ArrayObject;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaymentNormalizer implements NormalizerInterface
{
    /**
     * @param Payment $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|string|void|null
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'date' => $object->getDate(),
            'from' => $object->getFromGuest() ? [
                'id' => $object->getFromGuest()->getId(),
                'name' => $object->getFromGuest()->getName(),
                ]: null,
            'to' => $object->getToGuest() ? [
                'id' => $object->getToGuest()->getId(),
                'name' => $object->getToGuest()->getName(),
            ]: null,
            'cost' => $object->getCost() . ' RUB',
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Payment;
    }
}