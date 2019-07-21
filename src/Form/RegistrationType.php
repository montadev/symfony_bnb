<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,[
                'label'=>'Prenom',
                'attr'=>[

                    'placeholder'=>'Votre Prenom....'
                ]
            ])
            ->add('lastName',TextType::class,[
                'label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'Votre Nom de famille'
                ]
            ])
            ->add('email',EmailType::class,[
                'label'=>'Email',
                'attr'=>[
                    'placeholder'=>'Votre adresse email'
                ]
            ])
            ->add('picture',UrlType::class,[

                'label'=>"Photo de votre profil",
                'attr'=>[
                    'placeholder'=>'Url de votre avatar'
                ]
            ])
            ->add('password',PasswordType::class,[
                'label'=>'Mot de passe',
                'attr'=>[
                    'placeholder'=>'Votre mot de passe'
                ]
            ])
            ->add('passwordConfirm',PasswordType::class,[
                'label'=>"confirmation de mot de pass",
                'attr'=>[
                    'placeholder'=>"Veuillez confirmez votre mot de passe"
                ]
            ])
            ->add('introduction',TextType::class,[
                'label'=>'introduction',
                'attr'=>[
                    'placeholder'=>'Presentez vous en quelques Mot'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label'=>'Description Detaillée',
                'attr'=>[
                    'placeholder'=>"c'est le moment de vous présentez en details !"
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
