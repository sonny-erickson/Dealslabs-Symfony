<?php

namespace DealsBundle\Services;

use DealsBundle\Entity\Deal;
use DealsBundle\Entity\DealVote;
use DealsBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class DealsService
 * @package DealsBundle\Services
 */
class DealService
{
    /** @var KernelInterface $kernel */
    private $kernel;
    /** @var EntityManagerInterface $em */
    private $em;
    /** @var FileService $fileService */
    private $fileService;
    /** @var VoteService $voteService */
    private $voteService;
    /** @var UtilesService $utilesService */
    private $utilesService;

    /**
     * DealAddService constructor.
     * @param KernelInterface $kernel
     * @param UtilesService $utilesService
     * @param EntityManagerInterface $em
     * @param FileService $fileService
     * @param VoteService $voteService
     */
    public function __construct(KernelInterface $kernel, UtilesService $utilesService,EntityManagerInterface $em, FileService $fileService, VoteService $voteService)
    {
        $this->kernel = $kernel;
        $this->em = $em;
        $this->fileService = $fileService;
        $this->voteService = $voteService;
        $this->utilesService = $utilesService;
    }

    /**
     * @param Deal $deal
     * @param User $user
     * @throws \Exception
     */
    public function addDeal(Deal $deal, User $user)
    {
        $errorMessage = [];

        //Double check du Addform
        if(empty($deal->getDateExpiration())){
            $errorMessage[] = "La date d'expiration est obligatoire";
        }

        if(empty($deal->getDateDebut())){
            $errorMessage[] = "La date du début est obligatoire";
        }

        if(empty($deal->getUrl())){
            $errorMessage[] = "Le lien de l'offre est obligatoire";
        }

        if(empty($deal->getImage())){
            $errorMessage[] = "L'image est obligatoire ou elle n'est pas au format JPG";
        }

        if(!empty(count($errorMessage))){
            throw new LogicException(implode(", ", $errorMessage));
        }

        try{
            $upload = $this->uploadImageDeal($deal);
            $upload->setUser($user);
            $this->em->persist($upload);
            $this->em->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param \DealsBundle\Entity\Deal $deal
     * @return \DealsBundle\Entity\Deal
     * @throws \Exception
     */
    private function uploadImageDeal(Deal $deal)
    {
        /** @var UploadedFile $imageFile */
        $imageFile = $deal->getImage();
        $appDir = $this->kernel->getRootDir(); // C://USER/xampp/htdocs/PROJET/app/
        $webDir = $appDir . "/../web"; // C://USER/xampp/htdocs/PROJET/web
        $imgDir = Constantes::IMG_UPLOAD_DIRECTORY; // /uploads/image
        $filename = $deal->getPrixPromo() .$this->utilesService->slugify($deal->getTitre()) .$deal->getLocalisation() . "." . $imageFile->getClientOriginalExtension();

        try{
            $this->fileService->upload($webDir . "/" . $imgDir, $imageFile, $filename);
            $deal->setImage($imgDir . "/" . $filename);
            return $deal;
        }catch (\Exception $e){
            // TODO
        }

    }

    /**
     * @param \DealsBundle\Entity\Deal $deal
     * @return \DealsBundle\Entity\Deal
     */
    public function deleteDeal(Deal $deal)
    {
        // If deal have vote(s) -> delete in DB
        if(!empty($deal->getVotes())){
            foreach ($deal->getVotes() as $vote){
                $this->voteService->deleteVotesFromDeal($vote);
            }
        }
        try{
            //Now delete file in web folder
            $image = $deal->getImage(); // /uploads/image/MONIMAGE.png
            $appDir = $this->kernel->getRootDir(); // C://USER/xampp/htdocs/PROJET/app/
            $webDir = $appDir . "/../web"; // C://USER/xampp/htdocs/PROJET/web
            $pathToDelete = $webDir . $image;
            $this->fileService->deleteFile($pathToDelete);
            //For finish delete the deal in DB
            $this->em->remove($deal);
            $this->em->flush();
        }catch (\Exception $e){
            throw $e;
        }
        return $deal;
    }

    /**
     * @param $user
     * @param $request
     * @return Deal
     * @throws \Exception
     */
    public function createCounter($user, $request)
    {
        try {
            /** @var Deal $deal */
            $deal =  $this->em->getRepository(Deal::class)
                ->find( (int) $request->request->get('idDeal'));
            //add in bdd
            $voteAdd = new DealVote();
            $voteAdd->setDeal($deal);
            $voteAdd->setUser($user);
            $voteAdd->setCounter($request->request->get('upDown')=="up"? 1:-1);
            $this->em->persist($voteAdd);
            $this->em->flush();
        }catch (\Exception $e) {
            throw $e;
        }
        return $deal;
    }
}
