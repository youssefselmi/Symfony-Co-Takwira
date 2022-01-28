<?php

namespace App\Controller;
use App\Entity\Coach;
use App\Form\Coach1Type;
use App\Repository\CoachRepository;
use App\Entity\User;
//use http\Client\Curl\User;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MobilecoachController extends AbstractController
{

    /**
     * @Route("/coach_mobile", name="coach_mobile", methods={"GET"})
     */
    public function coachmobile( NormalizerInterface  $normalizer)
    {

        $coaches = $this->getDoctrine()
            ->getRepository(Coach::class)
            ->findAll();

        $json = $normalizer->normalize($coaches, "json", ['groups' => ['coachs']]);

        return new JsonResponse($json);

    }









    /**
     * @Route("/coach_mobile_stat", name="coach_mobile_stat", methods={"GET"})
     */

    public function StatAction()
    {
        $statistique=$this->getDoctrine()->getRepository(Coach::class)->statistique_abo();
        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize($statistique);
        return new JsonResponse($formated);
    }











    /**
     * @Route("/newcoach_mobile/{nom}/{prenom}/{date_naissence}/{grade}/{date_fin_contrat}/{adresse_mail}/{salaire}/{nb_trophe_locaux}/{nb_trophe_internationaux}/{formation_prefere}/{image_formation}/{image_coach}/{age}/{mdp_coach}", name="newcoach_mobile", methods={"GET","POST"})
     */
    public function new($nom,$prenom,$date_naissence,$grade,$date_fin_contrat,$adresse_mail,$salaire,$nb_trophe_locaux,$nb_trophe_internationaux,$formation_prefere,$image_formation,$image_coach,$age,$mdp_coach,NormalizerInterface  $normalizer)
    {

        $coach = new Coach();
        $coach->setNomCoach($nom);
        $coach->setPrenomCoach($prenom);
        $coach->setGrade($grade);
        $coach->setAdresseMail($adresse_mail);
        $coach->setSalaire($salaire);
        $coach->setNbTropheLocaux($nb_trophe_locaux);
        $coach->setNbTropheInternationaux($nb_trophe_internationaux);
        $coach->setFormationPrefere($formation_prefere);
        $coach->setImageFormation($image_formation);
        $coach->setImageCoach($image_coach);
        $coach->setAge($age);
        $coach->setMdpCoach($mdp_coach);
        $coach->setDateNaissance(new \DateTime((String)$date_naissence));
        $coach->setDateFinContrat(new \DateTime((String)$date_fin_contrat));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($coach);
        $entityManager->flush();
        $json = $normalizer->normalize($coach, "json", ['groups' => ['coachs']]);
        return new JsonResponse($json);


    }

}
