<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment")
     */
    public function index(CommentRepository $repo)
    {
        return $this->render('admin/comment//index.html.twig', [
            'comments' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/admin/comment/{id}/edit", name="admin_comment_edit")
     */

     public function edit(Comment $comment,ObjectManager $manager,Request $request)
     {

        $form=$this->createForm(AdminCommentType::class,$comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($comment);

            $manager->flush();

            $this->addFlash(
                'success',
                "Le Commentaire a bien été modifier"
            );
        }

        return $this->render('admin/comment/edit.html.twig',[

                'form'=>$form->createView(),
                'comment'=>$comment
        ]);
     }

     /**
     * @Route("/admin/comment/{id}/delete", name="admin_comment_delete")
     */

     public function delete(Comment $comment,ObjectManager $manager)
     {
         
        $manager->remove($comment);

        $manager->flush();

        $this->addFlash(
            'success',
            "Le Commentaire a bien été supprimer"
        );

        return $this->redirectToRoute('admin_comment');
     }
}
