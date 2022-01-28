<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Entity\Entrainement;
use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
class EquipeMobileController extends AbstractController
{
    /**
     * @Route("/equipe/mobile", name="equipe_mobile")
     */
    public function index(): Response
    {
        return $this->render('equipe_mobile/index.html.twig', [
            'controller_name' => 'EquipeMobileController',
        ]);
    }





    /**
     * @Route("/equipe_mobile", name="equipe_mobile")
     */
    public function equipemobile( NormalizerInterface  $normalizer)
    {


        $repository = $this->getDoctrine()->getRepository(Equipe::class);

        $equipes = $repository->findAll();
        $jsonContent = $normalizer->normalize($equipes, 'json',['equipes']);
        return new JsonResponse($jsonContent);


        /* $coaches = $this->getDoctrine()->getRepository(Equipe::class)->findAll();
         $json = $normalizer->normalize($coaches, "json", ['groups' => ['equipes']]);
         return new JsonResponse($json);*/



    }














    /**
     * @Route("/SupprimerEquipe", name="SupprimerEquipe")
     */
    public function SupprimerEquipe(Request $request)
    {

        $idE = $request->get("idE");
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Equipe::class)->find($idE);
        if($reclamation != null)
        {
            $em->remove($reclamation);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formated = $serializer->normalize("Equipe ete supprimer avec succées ");
            return new JsonResponse($formated);

        }

    }







}
