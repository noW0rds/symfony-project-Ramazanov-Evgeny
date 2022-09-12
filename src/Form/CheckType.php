<?php

namespace App\Form;

use App\Entity\Check;
use App\Entity\Guest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('store', TextType::class, [
                'label' => 'Магазин',
            ])
            ->add('buyingGuest', EntityType:: class, [
                'class' => Guest::class,
                'label' => 'Покупатель',
                'choice_label' => 'name',
                'placeholder' => 'выберите гостя',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Check::class,
        ]);
    }
}
