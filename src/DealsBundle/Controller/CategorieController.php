<?php


namespace DealsBundle\Controller;

use DealsBundle\Entity\Categorie;
use DealsBundle\Services\CategorieService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Translation\TranslatorInterface;

class CategorieController extends Controller
{

    /**
     *
     * @param Request $request
     * @return Response|null
     */
    public function findCategorieAction(Request $request)
    {
//        /** @var CategorieService $catService */
//        $catService = $this->get("myDealabs.categorieService");
//        $categories = $catService->getCategories();
//        // $keyToTranslate = "categorie.deals";
//        /** @var TranslatorInterface $translator */
//        // $translator = $this->get("translator");
//        // dump($translator->transChoice($keyToTranslate, 0));
//        return $this->render('DealsBundle:Default:testCat.html.twig',[
//            'categories' => $categories
//        ]);
    }


}