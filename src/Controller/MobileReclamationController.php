<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Coach;
use App\Repository\ReclamationRepository;
use App\Repository\CoachRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @Route("/reclamation")
 */
class MobileReclamationController extends AbstractController
{
    ////////////////////////////////////////////::Jason for CodeNameOne::////////////////////////////////////////////


    /**
     * @Route("/AffichageReclamation", name="AffichageReclamation")
     */
    public function AffichageReclamation( NormalizerInterface  $normalizer)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        $json = $normalizer->normalize($reclamation, "json", ['groups' => ['reclamation']]);
        return new JsonResponse($json);
    }

    /**
     * @Route("/SupprimerReclamation", name="SupprimerReclamation")
     * @Method("DELETE")
     */
    public function SupprimerReclamation(Request $request)
    {
        $id = $request->get("idRec");
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        if($reclamation != null)
        {
            $em->remove($reclamation);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formated = $serializer->normalize("Reclamation ete supprimer avec succées ");
            return new JsonResponse($formated);

        }

        return new JsonResponse("id Reclamation est invalide !");
    }


    /******************Ajouter Reclamation*****************************************/
    /**
     * @Route("/addReclamation", name="add_reclamation")
     * @Method("POST")
     */
    public function ajouterReclamationAction(Request $request)
    {
        $reclamation = new Reclamation();
        // $DescriptionRec = $request->query->get("DescriptionRec");
        $SujetRec = $request->query->get("SujetRec");
        $DateRec = $request->query->get("DateRec");
        $date = new \DateTime('now');
        $em = $this->getDoctrine()->getManager();
        $reclamation->setSujetrec($SujetRec);
        // $reclamation->setDescriptionrec($DescriptionRec);
        $reclamation->setDaterec($date);
        $reclamation->setStatusrec("non traite");
        $reclamation->setDescriptionrec($this->filterwords($request->query->get("DescriptionRec")));
        $em->persist($reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse($formatted);

    }

    function filterwords($text){
        $filterWords = array('fuck','test');
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }

    /******************Modifier Reclamation*****************************************/
    /**
     * @Route("/updateReclamation", name="update_reclamation")
     * @Method("PUT")
     */
    public function modifierReclamationAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($request->get("idRec"));
        $reclamation->setSujetrec($request->get("SujetRec"));
        $reclamation->setDescriptionrec($request->get("DescriptionRec"));

        $em->persist($reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse("Reclamation a ete modifiee avec success.");

    }


}