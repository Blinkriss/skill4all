<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;


class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbSeats', TextType::class, [
                'label' => 'Number of seats',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('nbDoors', TextType::class, [
                'label' => 'Number of doors',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Model of the car',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('cost', MoneyType::class, [
                'label' => 'Price of the car',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('carCategory', EntityType::class, [
                'label' => 'Category',
                'placeholder' => '-- Choose a category --',
                'class' => CarCategory::class,
                'choice_label' => function (CarCategory $carCategory) {
                    return strtoupper(($carCategory->getName()));
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
