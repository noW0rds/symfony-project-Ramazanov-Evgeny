<?php

namespace App\Form;

use App\Entity\Guest;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Имя',
            ])
            ->add('number', TextType::class, [
                'label' => 'Номер телефона',
            ])
            ->add('buyingProduct')
            ->add('whoUser', EntityType::class, [
                'class' => User::class,
                'label' => 'Пользователь',
                'choice_label' => 'email',
                'placeholder' => 'Выберите пользователя'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guest::class,
        ]);
    }
}
