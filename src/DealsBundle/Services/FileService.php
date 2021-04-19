<?php

namespace DealsBundle\Services;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;

class FileService
{
    /** @var KernelInterface $kernel */
    private $kernel;

    /**
     * FileService constructor.
     * @param KernelInterface $kernel
     */
    public function __construct( KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param $directory
     * @param UploadedFile $file
     * @param $filename
     */
    public function upload($directory, UploadedFile $file, $filename)
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }
        copy($file->getPathname(), $directory . "/" . $filename);
    }

    public function deleteFile($pathFileToDelete)
    {
         try{
             unlink($pathFileToDelete);
         }catch(\Exception $e){
             throw $e;
         }
    }
}