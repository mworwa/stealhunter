<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sale;
use AppBundle\Entity\Vote;
use AppBundle\Service\VotingService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VotingController extends Controller
{
    /**
     * @Route("/vote/add/{saleId}", name="vote_add")
     */
    public function addVote($saleId)
    {
        $votingService = $this->get('voting_service');
        $sale = $this->getDoctrine()->getManager()->getRepository('AppBundle:Sale')->find($saleId);
        if (!$sale instanceof Sale) {
            return new Response('Sale not found', 404);
        }
        if ($votingService->findOneByUserAndSale($sale, $this->getUser())) {
            return new Response('Already voted', 403);
        }
        $vote = new Vote();
        $vote->setSale($sale);
        $vote->setCreated(new \DateTime('now'));
        $vote->setUser($this->getUser());
        $votingService->addVote($vote);
        return new JsonResponse('success');
    }

    /**
     * @Route("/vote/remove/{saleId}", name="vote_remove")
     */
    public function removeVote($saleId)
    {
        $votingService = $this->get('voting_service');
        $sale = $this->getDoctrine()->getManager()->getRepository('AppBundle:Sale')->find($saleId);
        $vote = $votingService->findOneByUserAndSale($sale, $this->getUser());
        $votingService->removeVote($vote);
        return new Response('removed');

    }
}
