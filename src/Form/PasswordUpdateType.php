<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword',PasswordType::class,[
                'label'=>'Ancien mot de passe',
                'attr'=>[
                    'placeholder'=>'Donnez votre mot de passe actuel'
                ]
            ])
            ->add('newPassword',PasswordType::class,[
                'label'=>'Nouveau mot de passe',
                'attr'=>[
                    'placeholder'=>'Tapez votre nouveau mot de passe'
                ]
            ])
            ->add('confirmPassword',PasswordType::class,[
                'label'=>'confirmation de mot de passe',
                'attr'=>[
                    'placeholder'=>'Confirmez votre nouveau mot de passe'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
