<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function categoryListAction(Request $request)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category');
        $categories = $repo->findAll();

        return $this->render('admin/categories/list.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route("/admin/category/add", name="admin_category_add")
     */
    public function addCategoryAction(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category)
            ->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/categories/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/category/edit/{id}", name="admin_category_edit")
     */
    public function updateCategoryAction(Request $request, $id)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Category');
        $category = $repo->find($id);

        $form = $this->createForm(CategoryType::class, $category)
            ->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/categories/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param int $id
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     * @return RedirectResponse
     */
    public function deleteCategoryAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Category');
        $category = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('admin_category');
    }


}
