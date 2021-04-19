<?php


namespace DealsBundle\DataFixtures;

use DealsBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAuser extends AbstractFixture implements FixtureInterface
{
    const USER_REFERENCE = 'username';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i=0; $i < ConstanteFixture::NB_USERS; $i++) {
            $user = new User();
            $user->setUsername($faker->name);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $manager->persist($user);

            $this->addReference(self::USER_REFERENCE . "-" . $i, $user);
        }
        $manager->flush();
    }

}
