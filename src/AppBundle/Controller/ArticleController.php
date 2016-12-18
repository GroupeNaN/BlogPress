<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Comment;
use AppBundle\Form\ArticleType;
use AppBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->findBy(
            array(),
            array('date' => 'desc')
        );

        return $this->render('layout/index.html.twig', array('articles' => $articles));
    }

    /**
     * @Route("/article/{id}", name="view_article", requirements={"id": "\d+"})
     */
    public function viewAction(Request $request, Article $article)
    {
        $auth_checker = $this->get('security.authorization_checker');
        $isUser = $auth_checker->isGranted('ROLE_USER');

        if($isUser === true)
        {
            /* Gestion du formulaire pour ajouter un commentaire */
            $comment = new Comment();
            $comment->setArticle($article);
            $comment->setAuthor($this->getUser());
            $commentForm = $this->get('form.factory')->create(CommentType::class, $comment);

            if($request->isMethod('POST') && $commentForm->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', 'Votre commentaire a bien été publié.');

                return $this->redirectToRoute('view_article', array('id' => $article->getId()));
            }
        }


        return $this->render('layout/article/post.html.twig', array(
            'article' => $article,
            'comment_form' => isset($commentForm) ? $commentForm->createView() : NULL
        ));
    }

    /**
     * @Route("/article/add", name="add_article")
     */
    public function addAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'ROLE_ADMIN necessary');

        $article = new Article();
        $article->setAuthor($this->getUser());
        $form = $this->get('form.factory')->create(ArticleType::class, $article);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre article a bien été publié.');

            return $this->redirectToRoute('view_article', array('id' => $article->getId()));
        }

        return $this->render('layout/article/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/article/edit/{id}", name="edit_article", requirements={"id": "\d+"})
     */
    public function editAction(Request $request, Article $article)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'ROLE_ADMIN necessary');

        $form = $this->get('form.factory')->create(ArticleType::class, $article);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('success', 'L’article a bien été modifié.');

            return $this->redirectToRoute('view_article', array('id' => $article->getId()));
        }

        return $this->render('layout/article/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/article/delete/{id}", name="delete_article", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, Article $article)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'ROLE_ADMIN necessary');

        $form = $this->get('form.factory')->create();
        $form->add('save', SubmitType::class, array('label' => 'Supprimer l’article'));

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('warning', 'L’article a bien été supprimé.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('layout/article/delete.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }
}
