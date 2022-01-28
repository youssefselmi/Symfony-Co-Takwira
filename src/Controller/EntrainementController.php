<?php

namespace App\Controller;

use App\Entity\Entrainement;
use App\Form\Entrainement2Type;
use App\Repository\CoachRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EntrainementRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;





/**
 * @Route("/entrainement")
 */
class EntrainementController extends AbstractController
{
    /**
     * @Route("/", name="entrainement_index", methods={"GET"})
     */
    public function index(FlashyNotifier $flashy): Response
    {
        $flashy->primaryDark('Liste des coachs', 'http://your-awesome-link.com');


        $entrainements = $this->getDoctrine()
            ->getRepository(Entrainement::class)
            ->findAll();

        return $this->render('entrainement/index.html.twig', [
            'entrainements' => $entrainements,
        ]);
    }

    /**
     * @Route("/new", name="entrainement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entrainement = new Entrainement();
        $form = $this->createForm(Entrainement2Type::class, $entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrainement);
            $entityManager->flush();

            return $this->redirectToRoute('entrainement_index');
        }

        return $this->render('entrainement/new.html.twig', [
            'entrainement' => $entrainement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEntrainement}", name="entrainement_show", methods={"GET"})
     */
    public function show(Entrainement $entrainement): Response
    {
        return $this->render('entrainement/show.html.twig', [
            'entrainement' => $entrainement,
        ]);
    }

    /**
     * @Route("/{idEntrainement}/edit", name="entrainement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entrainement $entrainement): Response
    {
        $form = $this->createForm(Entrainement2Type::class, $entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entrainement_index');
        }

        return $this->render('entrainement/edit.html.twig', [
            'entrainement' => $entrainement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEntrainement}", name="entrainement_delete", methods={"POST"})
     */
    public function delete(Request $request, Entrainement $entrainement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrainement->getIdEntrainement(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entrainement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entrainement_index');
    }





    /**
     * @Route("/e/search_entrainement", name="search_entrainement", methods={"GET"})
     */
    public function search_produit(Request $request,NormalizerInterface $Normalizer,EntrainementRepository $EntrainementRepository ): Response
    {

        $requestString=$request->get('searchValue');
        $requestString2=$request->get('searchValue2');


        //   dump($requestString);
        //  dump($requestString2);
        $entrainements = $EntrainementRepository->findProduitsBySujet($requestString,$requestString2);
        //   dump($reclamations);
        $jsoncontentc =$Normalizer->normalize($entrainements,'json',['groups'=>'posts:read']);
        //  dump($jsoncontentc);
        $jsonc=json_encode($jsoncontentc);
        //   dump($jsonc);
        if(  $jsonc == "[]" )
        {
            return new Response(null);
        }
        else{        return new Response($jsonc);
        }

    }













    /**
     * @Route("/e/statyoussef", name="statyoussef", methods={"GET"})
     */
    public function reclamation_stat(EntrainementRepository $entrainementRepository): Response
    {
        $nbrs[]=Array();

        $e1=$entrainementRepository->find_Nb_Rec_Par_Status("Attaque");
        dump($e1);
        $nbrs[]=$e1[0][1];
        $e2=$entrainementRepository->find_Nb_Rec_Par_Status("Milieu");
        dump($e2);
        $nbrs[]=$e2[0][1];


        $e3=$entrainementRepository->find_Nb_Rec_Par_Status("Diffence");
        dump($e3);
        $nbrs[]=$e3[0][1];


        dump($nbrs);
        reset($nbrs);
        dump(reset($nbrs));
        $key = key($nbrs);
        dump($key);
        dump($nbrs[$key]);

        unset($nbrs[$key]);

        $nbrss=array_values($nbrs);
        dump(json_encode($nbrss));

        return $this->render('entrainement/statentrainement.html.twig', [
            'nbr' => json_encode($nbrss),
        ]);
    }


















}
