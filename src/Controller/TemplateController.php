<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Entity\Entrainement;
use App\Entity\Joueur;
use App\Entity\User;
use App\Repository\CoachRepository;
use App\Repository\EntrainementRepository;
use App\Repository\EquipeRepository;
use App\Repository\JoueurRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\Coach1Type;
use Symfony\Component\HttpFoundation\Request;





class TemplateController extends AbstractController
{
    /**
     * @Route("/template", name="template")
     */
    public function index(): Response
    {
        return $this->render('template/index.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }










    /**
     * @Route("/template", name="template", methods={"GET","POST"})
     */
    public function indexAction(Request $request)
    {

        return $this->render('template/index.html.twig',[

            'base_dir' => realpath($this->getParameter('kernel.project_dir'))


        ]);

    }







    /**
     * @Route("/templatefront", name="templatefront", methods={"GET","POST"})
     */
    public function index2(): Response
    {
        return $this->render('template/index2.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }










    /**
     * @Route("/login", name="login", methods={"GET","POST"})
     */
    public function index3(Request $reques): Response
    {

      // var_dump($reques->get('password'));

       $password=$reques->get('password');
        $email=$reques->get('email');



        $coach=$this->getDoctrine()->getRepository(User::class)->recupere_information_coach();
        $joueur=$this->getDoctrine()->getRepository(User::class)->recupere_information_joueur();



        for ($i=0 ;$i<count($coach) ;$i++)
        {
            if(   $coach[$i]['mdp_coach'] == $password && $coach[$i]['adresse_mail'] == $email )
            {
                $s=new Session();
                $s->set('user','user');
                $s->start();
                return $this->redirectToRoute('template');

            }
        }



        for ($i=0 ;$i<count($joueur) ;$i++)
        {
            if(   $joueur[$i]['password'] == $password && $joueur[$i]['adresse_mail'] == $email )
            {
                return $this->redirectToRoute('templatefrontequipe');

            }
        }

    }




































    /**
     * @Route("/template/Match", name="template_match")
     */
    public function match(): Response
    {
        //$requestsql = $this->getDoctrine()->getRepository(coach::class)->mise_a_jour();


        $coaches = $this->getDoctrine()
            ->getRepository(Coach::class)
            ->findAll();


        return $this->render('template/match.html.twig', [
            'controller_name' => 'TemplateController', 'coaches' => $coaches,

        ]);
    }






    /**
     * @Route("/template/Stade", name="template_stade")
     */
    public function stade(): Response
    {


        $entrainements = $this->getDoctrine()
            ->getRepository(Entrainement::class)
            ->findAll();


        return $this->render('template/stade.html.twig', [
            'controller_name' => 'TemplateController',  'entrainements' => $entrainements,
        ]);
    }
    /**
     * @Route("/template/AddMatch", name="addMatch")
     */
    public function AddMatch(): Response
    {
        return $this->render('template/addMatch.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/template/AddStade", name="addStade")
     */
    public function AddStade(): Response
    {
        return $this->render('template/addStade.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/template/updateStade", name="updateStade")
     */
    public function updateStade(): Response
    {
        return $this->render('template/updateStade.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/template/updateMatch", name="updateMatch")
     */
    public function updateMatch(): Response
    {
        return $this->render('template/updateMatch.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }















































    /**
     * @Route("/templatefront1", name="templatefront1")
     */
    public function home1(): Response
    {
        return $this->render('templatefront/home1.html.twig', [
            'controller_name' => 'TemplatefrontController',
        ]);
    }

    /**
     * @Route("/templatefront2", name="templatefront2")
     */
    public function home2(): Response
    {
        return $this->render('templatefront/home2.html.twig', [
            'controller_name' => 'TemplatefrontController',
        ]);
    }






    /**
     * @Route("/templatefrontcontactus", name="templatefrontcontactus")
     */
    public function contactus(): Response
    {
        return $this->render('templatefront/shop.html.twig', [
            'controller_name' => 'TemplatefrontController',
        ]);
    }







    /**
     * @Route("/templatefrontprosoccermedia1", name="templatefrontprosoccermedia1")
     */
    public function prosoccer1(): Response
    {
        return $this->render('templatefront/prosoccer1.html.twig', [
            'controller_name' => 'TemplatefrontController',
        ]);
    }



    /**
     * @Route("/templatefrontprosoccermedia2", name="templatefrontprosoccermedia2")
     */
    public function prosoccer2(): Response
    {
        return $this->render('templatefront/prosoccer2.html.twig', [
            'controller_name' => 'TemplatefrontController',
        ]);
    }




    /**
     * @Route("/{idEquipe}/templatefrontjoueurjunior", name="templatefrontjoueurjunior", methods={"GET","POST"})
     */
    public function joueurjunior(JoueurRepository $joueurRepository,$idEquipe): Response
    {
        return $this->render('templatefront/joueurjunior.html.twig', [
            'controller_name' => 'TemplatefrontController',
            'Joueurs' => $joueurRepository->createQueryBuilder('u')->select('u')->where("u.categorie = 'junior' and u.idEquipe=".$idEquipe)->getQuery()->getResult()

        ]);
    }


    /**
     * @Route("/{idEquipe}/templatefrontjoueursunior", name="templatefrontjoueursunior")
     */
    public function joueursunior(JoueurRepository $joueurRepository, $idEquipe): Response
    {
        return $this->render('templatefront/joueursunior.html.twig', [
            'controller_name' => 'TemplatefrontController',
            'Joueurs' => $joueurRepository->createQueryBuilder('u')->select('u')->where("u.categorie = 'sunior'  and u.idEquipe=".$idEquipe)->getQuery()->getResult()
        ]);
    }

    /**
     * @Route("/templatefrontequipe", name="templatefrontequipe")
     */
    public function equipe(EquipeRepository  $joueurRepository): Response
    {
        return $this->render('templatefront/equipe.html.twig', [
            'controller_name' => 'TemplatefrontController',
            'equipes' => $joueurRepository->createQueryBuilder('u')->select('u')->getQuery()->getResult()

        ]);
    }
    /**
     * @Route("/{idJoueur}/templatefrontdetailsjoueur", name="templatefrontdetailsjoueur")
     */
    public function detailjunior(Joueur $joueur, $idJoueur): Response
    {
        return $this->render('templatefront/jouerdetails.html.twig', [
            'controller_name' => 'TemplatefrontController',
            'joueur' => $joueur
        ]);
    }



    /**
     * @Route("/templatefrontcoachs", name="templatefrontcoach", methods={"GET","POST"})
     */
    public function coachs(CoachRepository $coachRepository): Response
    {
        return $this->render('templateFront/coachs.html.twig', [
            'controller_name' => 'TemplateController',
            'Coach' => $coachRepository->createQueryBuilder('u')->select('u')->getQuery()->getResult()

        ]);
    }







    /**
     * @Route("/templatefront2", name="templatefront2")
     */
    public function team(EntrainementRepository $entrainementRepository): Response
    {
        return $this->render('templatefront/bloglist.html.twig', [
            'controller_name' => 'TemplatefrontController',
            'Entrainement' => $entrainementRepository->createQueryBuilder('u')->select('u')->getQuery()->getResult()

        ]);
    }














    /**
     * @Route("/templatefrontmatchresult", name="templatefrontmatchresult")
     */
    public function matchresult(): Response
    {
        return $this->render('templatefront/matchresult.html.twig', [
            'controller_name' => 'TemplatefrontController',
        ]);
    }

    /**
     * @Route("/templatefrontmatchresultdetails", name="templatefrontmatchresultdetails")
     */
    public function matchresultdetails(): Response
    {
        return $this->render('templatefront/matchresultdetails.html.twig', [
            'controller_name' => 'TemplatefrontController',
        ]);
    }





    /**
     * @Route("/templatefrontarticles", name="templatefrontarticles")
     */
    public function articles(): Response
    {
        return $this->render('templatefront/artiles.html.twig', [
            'controller_name' => 'TemplatefrontController',
        ]);
    }




















}
