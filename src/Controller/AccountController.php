<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function index(AuthenticationUtils $utils)
    {
        $error=$utils->getLastAuthenticationError();

        $username=$utils->getLastUsername();
        
        return $this->render('account/login.html.twig',[

            'hasError'=>$error!==null,
            'username'=>$username
        ]);
    }

     /**
     * @Route("/logout", name="account_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/register", name="account_register")
     */

     public function register(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $encoder)
     {

         $user=new User;

         $form=$this->createForm(RegistrationType::class,$user);

         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid())
         {

            $user->setPassword($encoder->encodePassword($user,$request->request->get('registration[password]')));
             $manager->persist($user);
             $manager->flush();

             $this->addFlash('success',
               
             "Votre inscription a été bien ! Vous pouvez maintenant connectez"
         );

            return $this->redirectToRoute("account_login");
         }

         return $this->render('account/registration.html.twig',[

              'form'=>$form->createView()
         ]);
     }

/**
 * 
 * @Route("/account/profile",name="account_profile")
 *
 */
     public function profile(Request $request,ObjectManager $manager)
     {

         $user=$this->getUser();
         $form=$this->createForm(AccountType::class,$user);

         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid())
         {
             $manager->persist($user);

             $manager->flush();

             $this->addFlash('success',
               
             "Les données du profil ont été enregistréé avec succés"
         );
         }
         return $this->render('account/profile.html.twig',[

             'form'=>$form->createView()
         ]);

     }

      /**
       * @Route("/account/password-update",name="account_password")
       *
       */
     public function updatePassword(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $encoder)
     {

        $passwordUpdate=new PasswordUpdate;

        $user=$this->getUser();
        $form=$this->createForm(PasswordUpdateType::class,$passwordUpdate);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
           if(!password_verify ($passwordUpdate->getOldPassword(),$user->getPassword()))
           {

          $form->get('oldPassword')->addError(new FormError("

             Le mot de passe que vous avez tapez n'est pas votre mot de passe actuel
          "));

           }else
           {

            $hash=$encoder->encodePassword($user,$passwordUpdate->getNewPassword());

            $user->setPassword($hash);

            $manager->persist($user);

            $manager->flush();

            $this->addFlash('success',
               
            "Votre mot de passe a été bien modifié avec succés"
        );


        return $this->redirectToRoute('homepage');

           }
        }

       return $this->render("account/password.html.twig",[

        'form'=>$form->createView()
       ]);
     }

      /**
       * @Route("/account",name="account_index")
       *
       */
     public function myAccount()
     {

         return $this->render('user/index.html.twig',[

            'user'=>$this->getUser()

         ]);
     }
}
