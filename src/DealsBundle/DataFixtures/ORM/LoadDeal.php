<?php


namespace DealsBundle\DataFixtures;

use DealsBundle\Entity\Deal;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;


class LoadDeal extends AbstractFixture implements FixtureInterface
{
    const DEAL_REFERENCE = 'titre';
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i=0; $i < ConstanteFixture::NB_DEALS; $i++){
            $deal =new Deal();
            $deal->setTitre($faker->realText($maxNbChars = 25));
            $deal->setPrixOrigine($faker->numberBetween($min=10, $max=255));
            $deal->setPrixPromo($faker->numberBetween($min=1, $max=155));
            $deal->setDescription($faker->realText($maxNbChars = 200));
            $deal->setLivraison($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10));
            $deal->setDatePublication($faker->dateTimeInInterval($startDate = '-30 days', $interval = 'now', $timezone = null));
            $deal->setDateExpiration($faker->dateTimeInInterval($startDate = 'now', $interval = '+ 45 days', $timezone = null));
            $deal->setLocalisation($faker->city);
            $deal->setUrl($faker->url);
            $deal->setIsNational($faker->boolean);
            $deal->setDateDebut($faker->dateTimeInInterval($startDate = '-10 days', $interval = 'now', $timezone = null));
            $deal->setCategorie(
                $this->getReference(LoadCategorie::CATEGORIE_REFERENCE. "-" .rand(0,9)));
            $deal->setImage('http://placekitten.com/1000/1000');
            $deal->setUser(
                $this->getReference(LoadAuser::USER_REFERENCE . "-" . rand(0, 10)));
            $manager->persist($deal);
            $this->addReference(self::DEAL_REFERENCE . "-" . $i, $deal);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            LoadCategorie::class,
            LoadAuser::class
        ];
    }
}
