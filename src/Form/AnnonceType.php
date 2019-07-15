<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'label'=>'title',
                'attr'=>[
                    'placeholder'=>'taper un super title pour Votre annonce'
                ]
            ])
            ->add('slug',TextType::class)
            ->add('coverImage',UrlType::class,[
                'label'=>"Url de l'image principale",
                'attr'=>[
                    'placeholder'=>"Donne l'adress de l'image"
                ]
            ])
            ->add('introduction',TextType::class,[
                'label'=>'introduction',
                'attr'=>[
                    'placeholder'=>"Donnez une description globale de l'annonce"
                ]
            ])
            ->add('content',TextareaType::class,[
                'label'=>'Description détaillée',
                'attr'=>[
                    'placeholder'=>"Tapez une description qui donne vraiment envie de venir chez vous"
                ]
            ])
            ->add('price',MoneyType::class,[
                'label'=>'Prix/nuit',
                'attr'=>[
                    'placeholder'=>'indiquer le prix que vous voulez pour une nuit'
                ]
            ])
                      
           ->add('rooms',IntegerType::class,[

                'label'=>"Nombre de chambre",
                'attr'=>[
                    'placeholder'=>"Le nombre des chambres disponibles"
                ]
            ])
            ->add('save',SubmitType::class,[
                'label'=>'Enregistrer Votre Annonce'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
