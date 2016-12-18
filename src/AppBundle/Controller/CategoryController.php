<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     */
    public function indexAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        return $this->render('layout/category/index.html.twig', array('categories' => $categories));
    }

    /**
     * @Route("/category/{id}", name="view_category", requirements={"id": "\d+"})
     */
    public function viewAction(Request $request, Category $category)
    {
        return $this->render('layout/category/view.html.twig', array(
            'category' => $category
        ));
    }


    /**
     * @Route("/category/add", name="add_category")
     */
    public function addAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'ROLE_ADMIN necessary');

        $category = new Category();
        $form = $this->get('form.factory')->create(CategoryType::class, $category);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'La catégorie a bien été ajoutée.');

            return $this->redirectToRoute('categories');
        }

        return $this->render('layout/category/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/category/delete/{id}", name="delete_category", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, Category $category)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'ROLE_ADMIN necessary');

        $form = $this->get('form.factory')->create();
        $form->add('save', SubmitType::class, array('label' => 'Supprimer la catégorie'));

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('warning', 'La catégorie a bien été supprimée.');

            return $this->redirectToRoute('categories');
        }

        return $this->render('layout/category/delete.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }
}