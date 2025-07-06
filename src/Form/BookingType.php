<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //        $builder
        //            ->add('email')
        //            ->add('fullName');
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'your.email@email.com',
                ],
            ])
            ->add('fullName', TextType::class, [
                'attr' => [
                    'placeholder' => 'Jon Doe',
                    'pattern' => '[A-Z][a-z]+(?: [A-Z][a-z]+)+',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
