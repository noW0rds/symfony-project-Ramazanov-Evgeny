<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Guest;
use App\Entity\Party;
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

class PartyDenormalizer implements DenormalizerInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Party
    {
        if (key_exists('oldEntity', $context))
        {
            $party = $context['oldEntity'];
            if (key_exists('name', $data))
            {
                $party->setName($data['name']);
            }
            if (key_exists('date', $data))
            {
                $party->setDateAt(new \DateTimeImmutable($data['date']));
            }
            if (key_exists('location', $data))
            {
                $party->setLocation($data['location']);
            }
            if (key_exists('guests', $data))
            {
                $guests = $data['guests'];
                foreach ($guests as $g){
                    $guest = $this->em->getRepository(Guest::class)->find($g['id']);
                    $party->addPartyGuest($guest);
                }
            }
        }
        else
        {
            $party = new Party();
            $party->setName($data['name']);
            $party->setDateAt(new \DateTimeImmutable($data['date']));
            $party->setLocation($data['location']);
            $guests = $data['guests'];
            foreach ($guests as $g){
                $guest = $this->em->getRepository(Guest::class)->find($g['id']);
                $party->addPartyGuest($guest);
            }
        }
        return $party;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return Party::class == $type;

    }
}