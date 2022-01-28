<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Repository\RateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;


/**
 * @Route("/rate")
 */
class MobileRateController extends AbstractController
{
    ////////////////////////////////////////////::Jason for CodeNameOne::////////////////////////////////////////////

    /**
     * @Route("/AffichageRate", name="AffichageRate")
     */
    public function AffichageRate(NormalizerInterface  $normalizer)
    {
        $rate = $this->getDoctrine()->getRepository(Rate::class)->findAll();
        $jsonn = $normalizer->normalize($rate, "json", ['groups' => ['rate']]);
        return new JsonResponse($jsonn);
    }


    /**
     * @Route("/addrate" ,name="addrate")
     */
    public function addrate(Request $request,NormalizerInterface $normalizer,EntityManagerInterface $em)
    {
        $content=$request->getContent();
        $rate = new Rate();

        $rate->setIdcoach($request->get('idCoach'));
        $rate->setNomprenomcoach($request->get('nomprenomcoach'));
        $rate->setNomequipe($request->get('NomEquipe'));
        $rate->setDaterate($request->get('DateRate'));
        $rate->setRate($request->get('Rate'));

        $em->persist(
            $rate
        );
        $em->flush();
        $jsonContent = $normalizer->normalize($rate,'json',['groups' => 'rate']);
        return new Response(json_encode($jsonContent));

    }




}