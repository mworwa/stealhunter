<?php

namespace AppBundle\Controller;

use AppBundle\Service\Sorting\SorterFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $sales = $this->getDoctrine()->getRepository('AppBundle:Sale')->findAllOrderByCreateDate();
        foreach ($sales as $sale) {
            $saleVotingRating = $this->get('voting_service')->calculateVotesRating($sale);
            $sale->setRating($saleVotingRating);
        }
        $sorter = $this->get('sorter_factory')->create($sales, 'rating');
        $sales = $sorter->sort();

        return $this->render('front/index.html.twig', array(
            'categories' => $categories,
            'sales' => $sales
        ));
    }

    /**
     * @Route("/category/{categoryId}", name="categoryList")
     */
    public function categoryAction($categoryId) {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($categoryId);
        $sales = $this->getDoctrine()->getRepository('AppBundle:Sale')->findBy(['category' => $categoryId]);
        return $this->render('front/category_filter.html.twig', array(
            'category' => $category,
            'sales' => $sales
        ));
    }
}
