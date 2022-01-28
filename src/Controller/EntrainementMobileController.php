<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Entity\Entrainement;
use App\Entity\Reclamation;
use App\Form\Entrainement2Type;
use App\Repository\CoachRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EntrainementRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EntrainementMobileController extends AbstractController
{









    /**
     * @Route("/entrainement_mobile", name="entrainement_mobile")
     */
    public function entrainementmobile( NormalizerInterface  $normalizer)
    {
       /*

       $entrainements = $this->getDoctrine()
            ->getRepository(Entrainement::class)
            ->findAll();

        $json = $normalizer->normalize($entrainements, "json", ['groups' => ['entrainements']]);
        return new JsonResponse($json);
       */

        $coaches = $this->getDoctrine()->getRepository(Entrainement::class)->findAll();
        $json = $normalizer->normalize($coaches, "json", ['groups' => ['entrainements']]);
        return new JsonResponse($json);



    }









    /**
     * @Route("/newentrainement_mobile/{duree}/{heure}/{date_entrainement}/{type}/{id_coach}/{id_stade}/{id_equipe}", name="newentrainement_mobile", methods={"GET","POST"})
     */
    public function new($duree,$date_entrainement,$heure,$id_coach,$id_stade,$id_equipe,$type,NormalizerInterface  $normalizer)
    {

        $coach = new Entrainement();
        $coach->setDuree($duree);
        $coach->setDateEntrainement(new \DateTime((String)$date_entrainement));

        $coach->setHeure($heure);
        $coach->setIdCoach($id_coach);
        $coach->setIdStade($id_stade);
        $coach->setIdEquipe($id_equipe);
        $coach->setType($type);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($coach);
        $entityManager->flush();

        $json = $normalizer->normalize($coach, "json", ['groups' => ['entrainements']]);

        return new JsonResponse($json);





    }
























    /**
     * @Route("/SupprimerEntrainement", name="SupprimerEntrainement")
     */
    public function SupprimerEntrainement(Request $request)
    {

        $idE = $request->get("idEntrainement");
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Entrainement::class)->find($idE);
        if($reclamation != null)
        {
            $em->remove($reclamation);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formated = $serializer->normalize("Entrainement ete supprimer avec succées ");
            return new JsonResponse($formated);

        }

    }






    /******************Modifier Reclamation*****************************************/
    /**
     * @Route("/updateEntrainement", name="updateEntrainement")
     */
    public function modifierEntrainementAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Entrainement::class)->find($request->get("idEntrainement"));


        $reclamation->setDuree()($request->get("duree"));
        $reclamation->setType($request->get("type"));

        $em->persist($reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse("entrainement a ete modifiee avec success.");

    }














}
