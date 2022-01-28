<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Matchs;
use App\Entity\Nawres;
use App\Entity\Stade;
use App\Entity\User;
use App\Entity\Vote;
use App\Form\MatchsType;
use App\Form\NawresType;
use App\Form\StadeType;
use App\Form\MatchType;
use App\Repository\MatchsRepository;
use App\Repository\StadeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class MobileMatchController extends AbstractController
{


    /**
     * @param Request $request
     * @param SerializerInterface $serializerinterface
     * @Route ("/addS", name="addS")
     */
    public function AddS(Request $request,NormalizerInterface $Normalizer)
    {$em=$this->getDoctrine()->getManager();
        $u = new User();
        $u=$em->getRepository(User::class)->find($request->get('idUser'));


        $Stade = new Stade();
        $Stade->setAdresse($request->get('adresse'));
        $Stade->setNomStade($request->get('nomStade'));
        $Stade->setVille($request->get('ville'));
        $Stade->setCapacite($request->get('capacite'));
        $Stade->setIdUser($u);
        $em->persist($Stade);
        $em->flush();
        $json=$Normalizer->normalize($Stade,'json',['groups'=>'stade']);

        return new Response('Stade Ajouté');


    }
    /**
     *@Route("/listeStade",name="listeStade")
     */
    public function getStades(StadeRepository  $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer){
        $stades=$rep->findAll();

        $json=$Normalizer->normalize($stades,'json',['groups'=>'stade']);



        return new JsonResponse($json);

    }

    /**
     *@Route("/Vote/{id}",name="Vote")
     */
    public function getVote(MatchsRepository $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer,$id){
        $v=$rep->findVoteTotal($id);

        $json=$Normalizer->normalize($v,'json',['groups'=>'vote']);

        return new JsonResponse($json);

    }

    /**
     *@Route("/findStade/{nom}",name="findStade")
     */
    public function getStadeByNom(StadeRepository $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer,$nom){
        $v=$rep->findByNom($nom);

        $json=$Normalizer->normalize($v,'json',['groups'=>'stade']);

        return new JsonResponse($json);

    }

    /**
     *@Route("/mv",name="mv")
     */
    public function getMatchsV(MatchsRepository $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer){
        $v=$rep->findMatchV();

        $json=$Normalizer->normalize($v,'json',['groups'=>'vote']);

        return new JsonResponse($json);

    }

    /**
     *@Route("/listeUsers",name="listeUsers")
     */
    public function getUsers(StadeRepository  $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer){
        $em=$this->getDoctrine()->getManager();
        $u = new User();
        $u=$em->getRepository(User::class)->findAll();;


        $json=$Normalizer->normalize($u,'json',['groups'=>'stade']);


        return new JsonResponse($json);

    }



    /**
     *@Route("/findS/{id}",name="findS")
     */
    public function getStade(StadeRepository  $rep,$id,Request $request,NormalizerInterface $Normalizer){
        $stades=$rep->find($id);
        $json=$Normalizer->normalize($stades,'json',['groups'=>'stade']);

        return new JsonResponse($json);
    }

    /**
     *@Route("/findM/{id}",name="findM")
     */
    public function getMatch(MatchsRepository $rep,$id,Request $request,NormalizerInterface $Normalizer){
        $m=$rep->find($id);
        $json=$Normalizer->normalize($m,'json',['groups'=>'matchs']);

        return new JsonResponse($json);
    }


    /**
     *@Route("/findMb/{st}",name="findMb")
     */
    public function getMatchByDate(MatchsRepository $rep,$st,Request $request,NormalizerInterface $Normalizer){
        $m=$rep->findMatchByStade($st);
        $json=$Normalizer->normalize($m,'json',['groups'=>'matchs']);

        return new JsonResponse($json);
    }

    /**
     *@Route("/findE/{id}",name="findE")
     */
    public function getEquipe(MatchsRepository $rep,$id,Request $request,NormalizerInterface $Normalizer){
        $m=$rep->findEqp($id);
        $json=$Normalizer->normalize($m,'json',['groups'=>'matchs']);

        return new JsonResponse($json);
    }

    /**
     *@Route("/findMatchT",name="findMatchT")
     */
    public function getMatchT(MatchsRepository $rep,Request $request,NormalizerInterface $Normalizer){
        $m=$rep->findMatchTermine('Termine');
        $json=$Normalizer->normalize($m,'json',['groups'=>'matchs']);

        return new JsonResponse($json);
    }
    /**
     *@Route("/findMatchO",name="findMatchO")
     */
    public function getMatchO(MatchsRepository $rep,Request $request,NormalizerInterface $Normalizer){
        $m=$rep->findMatchTermine('En Programme');
        $json=$Normalizer->normalize($m,'json',['groups'=>'matchs']);

        return new JsonResponse($json);
    }


    /**
     * @param Request $request
     * @param SerializerInterface $serializerinterface
     * @Route ("/updateS/{id}", name="updateS")
     */
    public function UpdateS(Request $request,NormalizerInterface $Normalizer,$id)
    {$em=$this->getDoctrine()->getManager();

        $u = new User();
        $u=$em->getRepository(User::class)->find($request->get('idUser'));
        $Stade =$em->getRepository(Stade::class)->find($id);
        $Stade->setAdresse($request->get('adresse'));
        $Stade->setNomStade($request->get('nomStade'));
        $Stade->setVille($request->get('ville'));
        $Stade->setCapacite($request->get('capacite'));
        $Stade->setIdUser($u);
        $em->persist($Stade);
        $em->flush();
        $json=$Normalizer->normalize($Stade,'json',['groups'=>'stade']);

        return new Response("Stade updated successfully".json_encode($json));


    }
    /**
     * @param Request $request
     * @param SerializerInterface $serializerinterface
     * @Route ("/deleteS/{id}", name="deleteS")
     */
    public function deleteS(Request $request,NormalizerInterface $Normalizer,$id)
    {$em=$this->getDoctrine()->getManager();
        $Stade =$em->getRepository(Stade::class)->find($id);
        $em->remove($Stade);
        $em->flush();
        $json=$Normalizer->normalize($Stade,'json',['groups'=>'post:read']);

        return new Response("Stade deleted successfully".json_encode($json));


    }


    /**
     *@Route("/listeM",name="listeM")
     */
    public function getMatchs(MatchsRepository $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer){
        $matchs=$rep->findAll();
        $json=$Normalizer->normalize($matchs,'json',['groups'=>'matchs']);
        /*  dump($stades);
          die;*/
        return new JsonResponse($json);
    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializerinterface
     * @Route ("/addM", name="addM")
     */
    public function AddM(Request $request,NormalizerInterface $Normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $u = new User();
        $eq1 = new Equipe();
        $eq2 = new Equipe();
        $s = new Stade();
        //  $d = new \DateTime();

        // $u=$em->getRepository(User::class)->find($request->get('id_org'));
        $u=$em->getRepository(User::class)->find($request->get('id_org'));
        $eq1=$em->getRepository(Equipe::class)->find($request->get('id_equipe1'));
        $eq2=$em->getRepository(Equipe::class)->find($request->get('id_equipe2'));
        $s=$em->getRepository(Stade::class)->find($request->get('id_stade'));
        // $d=$em->find($request->get('date'));
        $m = new Matchs();
        $m->setDate(new \DateTime($request->get('date')));
        $m->setDescription($request->get('description'));
        $m->setHeureDeb($request->get('heure_deb'));
        $m->setHeureFin($request->get('heure_fin'));
        $m->setIdOrg($u);
        $m->setScore($request->get('score'));
        $m->setStatus($request->get('status'));
        $m->setIdEquipe1($eq1);
        $m->setIdEquipe2($eq2);
        $m->setIdStade($s);
        $m->setNbSpectateur($request->get('nb'));
        $em->persist($m);
        $em->flush();
        $json=$Normalizer->normalize($m,'json',['groups'=>'matchs']);

        return new Response('success');

    }
    /**
     * @param Request $request
     * @param SerializerInterface $serializerinterface
     * @Route ("/updateM/{id}", name="updateM")
     */
    public function UpdateM(Request $request,NormalizerInterface $Normalizer,$id)
    {$em=$this->getDoctrine()->getManager();
        $u = new User();
        $eq1 = new Equipe();
        $eq2 = new Equipe();
        $s = new Stade();
        //  $d = new \DateTime();

        $u=$em->getRepository(User::class)->find($request->get('id_org'));
        $eq1=$em->getRepository(Equipe::class)->find($request->get('id_equipe1'));
        $eq2=$em->getRepository(Equipe::class)->find($request->get('id_equipe2'));
        $s=$em->getRepository(Stade::class)->find($request->get('id_stade'));


        $m =$em->getRepository(Matchs::class)->find($id);
        $m->setDate(new \DateTime($request->get('date')));
        $m->setDescription($request->get('description'));
        $m->setHeureDeb($request->get('heure_deb'));
        $m->setHeureFin($request->get('heure_fin'));
        $m->setIdOrg($u);
        $m->setScore($request->get('score'));
        $m->setStatus($request->get('status'));
        $m->setIdEquipe1($eq1);
        $m->setIdEquipe2($eq2);
        $m->setIdStade($s);
        $em->persist($m);
        $em->flush();
        $json=$Normalizer->normalize($m,'json',['groups'=>'post:read']);

        return new Response("Match updated successfully".json_encode($json));


    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializerinterface
     * @Route ("/deleteM/{id}", name="deleteM")
     */
    public function deleteM(Request $request,NormalizerInterface $Normalizer,$id)
    {$em=$this->getDoctrine()->getManager();
        $m =$em->getRepository(Matchs::class)->find($id);
        $em->remove($m);
        $em->flush();
        $json=$Normalizer->normalize($m,'json',['groups'=>'post:read']);

        return new Response("Match deleted successfully".json_encode($json));


    }
    /**
     *@Route("/listeStades",name="listeStades")
     */
    public function getMesStades(StadeRepository  $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer){
        $em=$this->getDoctrine()->getManager();
        $u = new Stade();
        $u=$em->getRepository(Stade::class)->findAll();;


        $json=$Normalizer->normalize($u,'json',['groups'=>'matchs']);


        return new JsonResponse($json);

    }
    /**
     *@Route("/s/{nom}",name="s")
     */
    public function getByStadeNom(StadeRepository  $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer,$nom){
        $em=$this->getDoctrine()->getManager();
        $u = new Stade();
        $u=$em->getRepository(Stade::class)->findByNom($nom);


        $json=$Normalizer->normalize($u,'json',['groups'=>'matchs']);


        return new JsonResponse($json);

    }
    /**
     *@Route("/listeEq",name="listeEq")
     */
    public function getMesEquipes(StadeRepository  $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer){
        $em=$this->getDoctrine()->getManager();
        $u = new Equipe();
        $u=$em->getRepository(Equipe::class)->findAll();;


        $json=$Normalizer->normalize($u,'json',['groups'=>'matchs']);


        return new JsonResponse($json);

    }
    /**
     *@Route("/e/{nom}",name="e")
     */
    public function getByEqNom(StadeRepository  $rep,SerializerInterface $serializerinterface,NormalizerInterface $Normalizer,$nom){
        $em=$this->getDoctrine()->getManager();
        $u = new Equipe();
        $u=$em->getRepository(Matchs::class)->findEqpByNom($nom);


        $json=$Normalizer->normalize($u,'json',['groups'=>'matchs']);


        return new JsonResponse($json);

    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializerinterface
     * @Route ("/addV", name="addV")
     */
    public function AddVote(Request $request,NormalizerInterface $Normalizer)
    {$em=$this->getDoctrine()->getManager();
        $u = new User();
        $u=$em->getRepository(User::class)->find($request->get('idUser'));

        $m = new Matchs();
        $m=$em->getRepository(Matchs::class)->find($request->get('idMatch'));

        $v = new Vote();
        $v->setIdUser($request->get('idUser'));
        $v->setIdMatch($request->get('idMatch'));
        $v->setVote($request->get('vote'));


        $em->persist($v);
        $em->flush();
        $json=$Normalizer->normalize($v,'json',['groups'=>'vote']);

        return new Response('Vote Ajouté');


    }
}
