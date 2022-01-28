<?php

namespace App\Controller;

use App\Entity\Stade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StadeController extends AbstractController
{
    /**
     * @Route("/stade", name="stade")
     */
    public function index(): Response
    {
        return $this->render('stade/index.html.twig', [
            'controller_name' => 'StadeController',
        ]);
    }
    /**
     * @Route("/AfficherStade", name="AfficherStade")
     */
    public function AfficherStade(): Response
    {

        $Stades=$this->getDoctrine()->getRepository(Stade::class)->findAll();
        return $this->render('stade/stade.html.twig', [
            'c' => $Stades,
        ]);
    }
    /**
     * @Route("/supprimerStade/{id}", name="supprimerStade")
     */
    public function supprimerStade($id): Response
    {

        $stade=$this->getDoctrine()->getRepository(Stade::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($stade);
        $em->flush();
        return $this->redirectToRoute("AfficherStade");
    }



}
