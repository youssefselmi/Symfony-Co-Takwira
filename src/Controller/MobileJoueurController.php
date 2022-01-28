<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Joueur;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;




use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;




class MobileJoueurController extends AbstractController
{
    /**
     * @Route("/mobile/joueur", name="mobile_joueur")
     */
    public function index(): Response
    {
        return $this->render('mobile_joueur/index.html.twig', [
            'controller_name' => 'MobileJoueurController',
        ]);
    }





    /**
     * @Route("/{idEquipe}/listJoueur", name="equipe_listJoueurr", methods={"GET"})
     */
    public function listJoueur(NormalizerInterface $normalizer,$idEquipe)
    {
        $requestsql = $this->getDoctrine()->getRepository(Joueur::class)->mise_a_jour();

        $repository = $this->getDoctrine()->getRepository(Joueur::class);


        $joueurs = $repository->createQueryBuilder('u')->where("u.categorie = 'junior' and u.idEquipe=".$idEquipe)->getQuery()->getResult();
        $jsonContent = $normalizer->normalize($joueurs, 'json',['joueurs']);
        return new JsonResponse($jsonContent);






    }


    /**
     * @Route("/{idEquipe}/listJoueure", name="equipe_listJoueur", methods={"GET"})
     */
    public function listJoueur4(NormalizerInterface $normalizer,$idEquipe)
    {
        $repository = $this->getDoctrine()->getRepository(Joueur::class);


        $joueurs = $repository->createQueryBuilder('u')->where("u.categorie = 'sunior' and u.idEquipe=".$idEquipe)->getQuery()->getResult();
        $jsonContent = $normalizer->normalize($joueurs, 'json',['joueurs']);
        return new JsonResponse($jsonContent);
    }
    /**
     * @Route("/newjoueur_mobile/{nom}/{prenom}/{date_naissance}/{numero}/{adresse_mail}/{ville}/{position}/{id_e}/{image}/{password}", name="newjoueur_mobile", methods={"GET","POST"})
     */
    public function new($nom,$prenom,$date_naissance,$numero,$adresse_mail,$ville,$position,$id_e,$image,$password,NormalizerInterface  $normalizer , EquipeRepository $repository)
    {

        $joueur = new Joueur();
        $joueur->setNomJoueur($nom);
        $joueur->setPrenomJoueur($prenom);

        $joueur->setDateNaissance(new \DateTime((String)$date_naissance));

        $aujourdhui = date("Y-m-d");
        $diff = date_diff($joueur->getDateNaissance(), date_create($aujourdhui));
        $joueur->setAgeJoueur( $diff->format('%y'));
        $joueur->setNumero($numero);
        $joueur->setAdresseMail($adresse_mail);
        $joueur->setVille($ville);
        if($joueur->getAgeJoueur()<=18)
        {$joueur->setCategorie("junior");}
        else {$joueur->setCategorie("sunior");}
        $joueur->setPosition($position);


        $equipe = $repository->find($id_e);
        $joueur->setIdEquipe($equipe);





        $joueur->setImage($image);

        $joueur->setPassword($password);




        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($joueur);
        $entityManager->flush();

        $json = $normalizer->normalize($joueur, "json", ['groups' => ['joueurs']]);

        return new JsonResponse($json);





    }


















    /**
     * @Route("/joueur_mobile_stat", name="joueur_mobile_stat", methods={"GET"})
     */

    public function StatAction()
    {
        $statistique=$this->getDoctrine()->getRepository(Joueur::class)->statistique_abo();
        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize($statistique);
        return new JsonResponse($formated);
    }











}
