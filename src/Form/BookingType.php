<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',TextType::class,[
                'label'=>'Date d\'arrivée',
                
                'attr'=>[
                    'placeholder'=>'La date a laquelle vous comptez arrivez',
                     'autocomplete'=>'off'
                ]
            ])
            ->add('endTime',TextType::class,[
                'label'=>'Date de départ',
               
                'attr'=>[
                    'placeholder'=>'La date a laquelle vous quittez les lieux',
                    'autocomplete'=>'off'
                ]
            ])
            ->add('comment',TextareaType::class,[
                'label'=>false,
                'required'=>false,
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
