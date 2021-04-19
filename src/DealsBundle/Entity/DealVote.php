<?php

namespace DealsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DealVote
 *
 * @ORM\Table(name="deal_vote")
 * @ORM\Entity(repositoryClass="DealsBundle\Repository\DealVoteRepository")
 */
class DealVote
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="counter", type="integer", nullable=true)
     */
    private $counter;

    /**
     * @var Deal
     * @ORM\ManyToOne (targetEntity="Deal", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false, name="deal_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $deal;

    /**
     * @var User
     * @ORM\ManyToOne (targetEntity="User", inversedBy="vote")
     * @ORM\JoinColumn(nullable=false, name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set counter
     *
     * @param integer $counter
     *
     * @return DealVote
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get counter
     *
     * @return int
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @return Deal
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param Deal $deal
     */
    public function setDeal($deal)
    {
        $this->deal = $deal;
    }
}

