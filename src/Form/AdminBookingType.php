<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\User;
use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AdminBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('endTime',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('comment')
            ->add('booker',EntityType::class,[
                'class' => User::class,
                'choice_label' => 'firstName',
            ])
            ->add('ad',EntityType::class,[
                'class' => Ad::class,
                'choice_label' => 'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'validation_groups' => [
                'front','Default'
                ]
        ]);
    }
}
