<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sale;
use AppBundle\Form\SaleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    /**
     * @Route("/sale/add", name="sale_add")
     */
    public function addAction(Request $request)
    {
        $sale = new Sale();
        $sale->setUser($this->getUser());
        $sale->setIconImage('test');
        $form = $this->createForm(SaleType::class, $sale)
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sale);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('front/sale/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/sale/show/{id}", name="sale_show")
     */
    public function showAction($id)
    {
        $sale = $this->getDoctrine()->getRepository('AppBundle:Sale')->find($id);
        return $this->render('front/sale/show.html.twig', array(
            'sale' => $sale
        ));
    }
}
