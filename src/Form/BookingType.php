<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\frenshoTodate;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends AbstractType
{

    private $transformer;

    public function __construct(frenshoTodate $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',TextType::class,[
                'label'=>'Date d\'arrivée',
                'invalid_message' => 'Vous devez fournir une date valide!(exmple:31/07/2019)',
                
                'attr'=>[
                    'placeholder'=>'La date a laquelle vous comptez arrivez',
                     'autocomplete'=>'off'
                ]
            ])
            ->add('endTime',TextType::class,[
                'label'=>'Date de départ',
                'invalid_message' => 'Vous devez fournir une date valide!(exmple:31/07/2019)',
               
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

        $builder->get('startDate')
            ->addModelTransformer($this->transformer);
        
        $builder->get('endTime')
            ->addModelTransformer($this->transformer);    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
