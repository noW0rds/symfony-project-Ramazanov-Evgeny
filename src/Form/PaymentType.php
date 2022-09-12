<?php

namespace App\Form;

use App\Entity\Payment;
use App\Entity\Guest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cost', IntegerType::class, [
                'label' => 'Сумма'
            ])
            ->add('fromGuest', EntityType::class, [
                'class' => Guest::class,
                'label' => 'От кого',
                'choice_label' => 'name',
                'placeholder' => 'выберите гостя',
            ])
            ->add('toGuest', EntityType::class, [
                'class' => Guest::class,
                'label' => 'Кому',
                'choice_label' => 'name',
                'placeholder' => 'выберите гостя',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
