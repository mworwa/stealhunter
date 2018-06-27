<?php
/**
 * Created by PhpStorm.
 * User: marcinworwa
 * Date: 08.05.2018
 * Time: 19:20
 */

namespace AppBundle\Service;


use AppBundle\Entity\Sale;
use AppBundle\Entity\User;
use AppBundle\Entity\Vote;
use AppBundle\Repository\VoteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;

class VotingService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function addVote(Vote $vote)
    {
        $this->em->persist($vote);
        try {
            $this->em->flush($vote);

        } catch (OptimisticLockException $exception) {
            $exception->getMessage();
        }
    }

    public function removeVote(Vote $vote)
    {
        $this->em->remove($vote);
        try {
            $this->em->flush();

        } catch (OptimisticLockException $exception) {
            $exception->getMessage();
        }
    }

    /**
     * @param Sale $sale
     * @param User $user
     * @return Vote|null|object
     */
    public function findOneByUserAndSale(Sale $sale, User $user)
    {
        $vote = $this->em->getRepository('AppBundle:Vote')
            ->findOneBy(array('sale' => $sale->getId(), 'user' => $user->getId()));
        return $vote;
    }

    public function calculateVotesRating(Sale $sale) {
        $rating = (count($sale->getVotes()) / 10);
        $createdTime = $sale->getCreated()->format('Y-m-d H:i:s');
        $age = time() - strtotime($createdTime);
        if ($age < 86400) {
            $rating = $rating * 1.5;
        }

        return $rating;
    }
}