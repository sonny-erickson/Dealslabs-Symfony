<?php


namespace DealsBundle\Services;

use DealsBundle\Entity\DealVote;
use Doctrine\ORM\EntityManagerInterface;

class VoteService
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * VoteService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function deleteVotesFromDeal($vote){
        $this->em->remove($vote);
        $this->em->flush();
    }
}


