<?php

namespace DealsBundle\Services;

use DealsBundle\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;

class CategorieService
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * CategorieService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getCategories()
    {
        try {
            $categorieRepo = $this->em->getRepository(Categorie::class);
        }catch (\Exception $e){
            throw $e;
        }
        return $categorieRepo->findAll();
    }
}