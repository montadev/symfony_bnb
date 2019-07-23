<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',DateType::class,[
                'label'=>'Date d\'arrivée',
                'widget' => 'single_text',
                'attr'=>[
                    'placeholder'=>'La date a laquelle vous comptez arrivez'
                ]
            ])
            ->add('endTime',DateType::class,[
                'label'=>'Date de départ',
                'widget' => 'single_text',
                'attr'=>[
                    'placeholder'=>'La date a laquelle vous quittez les lieux'
                ]
            ])
            ->add('comment',TextareaType::class,[
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Si vous avez un commentaire,n\'hesitez pas à en faire part !'
                ]
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
