<?php

namespace DealsBundle\Services;

use DealsBundle\Entity\Deal;
use DealsBundle\Entity\DealVote;
use DealsBundle\Entity\User;

class UserService
{
    /**
     * @param User $user
     * @param Deal $deal
     * @return bool
     */
    public function hasBeenVoted(User $user, Deal $deal)
    {
        try {
            /** @var DealVote $dealVote */
            foreach ($user->getVote() as $dealVote) {
                if ($dealVote->getDeal() === $deal) return true;
            }
        }catch
            (\Exception $e){
                throw $e;
            }
        return false;
    }
}