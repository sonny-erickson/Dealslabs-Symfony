<?php


namespace DealsBundle\DataFixtures;

use DealsBundle\Entity\DealVote;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;



class LoadVote extends AbstractFixture implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Tableau des possibilité de choix
        $countersPossibilities = [-1, 1, 1, 1];
        //1er boucle -> pour chaq nb de DEALS
        for($i = 0; $i < ConstanteFixture::NB_DEALS; $i++){
            $nbUsersChosen = rand(0, ConstanteFixture::NB_USERS);
            //tableau dans lesquel on va add
            $preventedUsers = [];
            for($j = 0; $j < $nbUsersChosen; $j++){
                $userIdRand = rand(0, ConstanteFixture::NB_USERS);
                //si la valeur $userIdRand est dans le tableau $preventedUsers,
                // on recommence la boucle du début sinon on poursuit
                if(in_array($userIdRand, $preventedUsers)){
                    continue;
                }
                //on ajoute ce user dans l'array
                $preventedUsers[] = $userIdRand;
                $vote = new DealVote();
                // on met dans la row counter un chiffre random de $countersPo.... [-1, 1, 1, 1];
                $vote->setCounter($countersPossibilities[array_rand($countersPossibilities)]);
                //
                $vote->setDeal(
                    $this->getReference(LoadDeal::DEAL_REFERENCE. "-" .$i));
                $vote->setUser(
                    $this->getReference(LoadAuser::USER_REFERENCE . "-" . $userIdRand));
                $manager->persist($vote);
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            LoadDeal::class,
            LoadAuser::class
        ];
    }
}
