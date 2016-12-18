<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller
{
    /**
     * @Route("/comment/delete/{id}", name="delete_comment", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, Comment $comment)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'ROLE_ADMIN necessary');

        $form = $this->get('form.factory')->create();
        $form->add('save', SubmitType::class, array('label' => 'Supprimer le commentaire'));

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $article = $comment->getArticle();

            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();

            $request->getSession()->getFlashBag()->add('warning', 'Le commentaire a bien été supprimé.');

            return $this->redirectToRoute('view_article', array('id' => $article->getId()));
        }

        return $this->render('layout/comment/delete.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        ));
    }
}