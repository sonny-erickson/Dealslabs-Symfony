<?php


namespace DealsBundle\DataFixtures;

use DealsBundle\Entity\Categorie;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategorie extends AbstractFixture implements FixtureInterface
{
    const CATEGORIE_REFERENCE = 'nom';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i=0; $i<=9; $i++) {
            $categorie = new Categorie();
            $categorie->setNom($faker->word );
            $manager->persist($categorie);
            $this->addReference(self::CATEGORIE_REFERENCE . "-" . $i, $categorie);
        }
        $manager->flush();
    }

}