<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Form\RateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoachRepository;
use App\Repository\RateRepository;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @Route("/rate")
 */
class RateController extends AbstractController
{
    /**
     * @Route("/", name="rate_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rates = $this->getDoctrine()
            ->getRepository(Rate::class)
            ->findAll();

        return $this->render('rate/index.html.twig', [
            'rates' => $rates,
        ]);
    }

    /**
     * @Route("/new", name="rate_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rate = new Rate();

        $rate->setDaterate(new \DateTime('now'));
        $rate->setIdcoach(2); // be3ed chtwali dynamique
        $rate->setNomprenomcoach('Hamza agrebi'); // be3ed chtwali dynamique
    
        
        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rate);
            $entityManager->flush();

            return $this->redirectToRoute('rate_index');
        }

        return $this->render('rate/new.html.twig', [
            'rate' => $rate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idrate}", name="rate_show", methods={"GET"})
     */
    public function show(Rate $rate): Response
    {
        return $this->render('rate/show.html.twig', [
            'rate' => $rate,
        ]);
    }

    /**
     * @Route("/{idrate}/edit", name="rate_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rate $rate): Response
    {
        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rate_index');
        }

        return $this->render('rate/edit.html.twig', [
            'rate' => $rate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idrate}", name="rate_delete", methods={"POST"})
     */
    public function delete(Request $request, Rate $rate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rate->getIdrate(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rate_index');
    }


 
        /**
     * @Route("/r/rate_stat", name="rate_stat", methods={"GET"})
     */
    public function reclamation_stat(RateRepository $rateRepository): Response
    {
        $nbrs[]=Array();
        
            $e2=$rateRepository->find_Nb_Rec_Par_Status();
            dump($e2);
            $nbrs[]=$e2[0][1];
            dump($nbrs);
        reset($nbrs);
     //  dump(reset($nbrs));
        $key = key($nbrs);
       // dump($key);
       // dump($$nbrs[$key]);

        unset($nbrs[$key]);
      
        $nbrss=array_values($nbrs);
      //  dump(json_encode($nbrss));
        
        return $this->render('rate/stat.html.twig', [
            'nbr' => json_encode($nbrss),
        ]);
    }

}
