<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachMobileController extends AbstractController
{
    /**
     * @Route("/coach/mobile", name="coach_mobile")
     */
    public function index(): Response
    {
        return $this->render('coach_mobile/index.html.twig', [
            'controller_name' => 'CoachMobileController',
        ]);
    }
}
