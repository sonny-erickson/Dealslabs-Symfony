<?php

namespace DealsBundle\Controller;

use Cassandra\Exception\UnauthorizedException;
use DealsBundle\Entity\Deal;
use DealsBundle\Form\DealType;
use DealsBundle\Form\SearchFindType;
use DealsBundle\Services\DealService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Translation\TranslatorInterface;

class DealController extends Controller
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response|null
     */
    public function searchAction(Request $request)
    {
        /** @var TranslatorInterface $translator */
        $translator = $this->get("translator");
        try {
            $typeSearch = $request->get("typeSearch");
            $formSearch = $this->createForm(SearchFindType::class, [
                'translator' => $this->get("translator")
            ]);
            $dealRepo = $this->getDoctrine()->getManager()->getRepository(Deal::class);
            $deals = $dealRepo->findDealsBySearch($typeSearch);

            $formSearch->handleRequest($request);
            if($formSearch->isSubmitted() && $formSearch->isValid())
            {
                $data=$formSearch->getData();
                $deals = $dealRepo->findSearch($data);
            }
        }catch (\Exception $e){
            $this->addFlash('error',$translator->trans("deal.search.impossible"));
            return $this->redirectToRoute("home");
        }
        return $this->render('DealsBundle:Default:index.html.twig',[
            'form' =>$formSearch->createView(),
            //si je veux une pagination : 'deals' => pagination
            'deals' => $deals,
            'typeSearch' => $typeSearch,
        ]);
    }

    /**
     * @Route("/ajax/paginate/deals")
     * @param Request $request
     * @return Response|null
     */
    public function scrollDeals(Request $request)
    {
        /** @var TranslatorInterface $translator */
        $translator = $this->get("translator");
        $position = $request->request->get('position');
        try {
            $deals = $this->getDoctrine()->getManager()->getRepository(Deal::class)
                ->findScrollDeals($request->request->get('nbDeal'), $position, $request->request->get('typeSearch'));
        }catch (\Exception $e){
            $this->addFlash('error',$translator->trans("deal.scroll.impossible"));
            return $this->redirectToRoute("home");
        }
        return new JsonResponse([
            "nbDealsReturned" => count($deals),
            'html'=> $this->renderView('DealsBundle:Default:dealsList.html.twig', [
                'deals' => $deals,
                'position' => $position + 1,
            ]),
        ]);
    }

    /**
     * @Route("/deal/{id}", name="deal_detail")
     * @ParamConverter ("deal", class="DealsBundle\Entity\Deal")
     * @param Request $request
     * @param Deal $deal
     * @return Response|null
     */
    public function dealDetail(Request $request, Deal $deal)
    {
        return new JsonResponse([
            "deal" => $deal,
            'html' => $this->renderView('DealsBundle:Default:dealDetail.html.twig', [
                'deal' => $deal
            ]),
       ]);
    }

    /**
     * @Route("/ajax/deal/updateCounter", name="ajax_deal_updateCounter")
     * @param Request $request
     * @return Response|null
     */
    public function updateCounter(Request $request)
    {
        /** @var TranslatorInterface $translator */
        $translator = $this->get("translator");
        $user = $this->getUser();
        if(empty($user)){
            throw new UnauthorizedException($translator->trans("deal.counter.unauthorized.user"), 500, "/");
        }
        try {
            /** @var DealService $dealCounter */
            $dealCounter = $this->get("myDealabs.dealService");
            //Call changeCounter service
            $deal = $dealCounter->createCounter($user, $request);
        }catch (\Exception $e){
            return $this->redirectToRoute("home");
        }
        return new JsonResponse($deal->getSumVotes());
    }

    /**
     * @Route("/new_deal", name="newDeal")
     * @Security ("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response|null
     */
    public function addAction(Request $request)
    {
        /** @var TranslatorInterface $translator */
        $translator = $this->get("translator");
        $deal = new Deal();
        $form = $this->createForm(DealType::class, $deal,  [
            'translator' => $this->get("translator")
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user=$this->getUser();

            /** @var DealService $dealService */
            $dealService = $this->get("myDealabs.dealService");
            try{
                $dealService->addDeal($deal, $user);
                $this->addFlash('success',$translator->trans("deal.add"));
                return $this->redirectToRoute("mon_profil");
            }catch (LogicException $e){
                $this->addFlash('error',$e->getMessage());
                return $this->render('DealsBundle:Default:addForm.html.twig',[
                    'form' => $form->createView()
                ]);
            }
        }
        return $this->render('DealsBundle:Default:addForm.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/monProfil", name="mon_profil")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response|null
     */
    public function profileAction(Request $request)
    {
        /** @var TranslatorInterface $translator */
        $translator = $this->get("translator");
        try {
            $em = $this->getDoctrine()->getManager();
            $deals = $em->getRepository(Deal::class)
                ->findDealsByUser($this->getUser());
            return $this->render('DealsBundle:Default:profile.html.twig',[
                'deals' => $deals
            ]);
        }catch (\Exception $e){
            $this->addFlash('error',$translator->trans("deal.profile.load"));
            return $this->redirectToRoute("home");
        }
    }

    /**
     * @Route ("/delete/{id}",name="deal_delete")
     * @param Request $request
     * @param Deal $deal
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteDealAction(Request $request, Deal $deal)
    {
        /** @var TranslatorInterface $translator */
        $translator = $this->get("translator");
        try {
            /** @var DealService $dealService */
            $dealService = $this->get("myDealabs.dealService");
            $dealService->deleteDeal($deal);
            $this->addFlash('success',$translator->trans("deal.delete.success"));
        }catch (\Exception $e){
            $this->addFlash('error',$translator->trans("deal.delete.error"));
            return $this->redirectToRoute('mon_profil');
        }
        return $this->redirectToRoute('mon_profil');
    }

}