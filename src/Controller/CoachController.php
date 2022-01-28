<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Form\Coach1Type;
use commandeBundle\Repository\CoachRepository;

use commandeBundle\Repository\UserRepository;
use App\Entity\User;

//use http\Client\Curl\User;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/coach")
 */
class CoachController extends AbstractController
{
    /**
     * @Route("", name="coach_index", methods={"GET"})
     */
    public function index(FlashyNotifier $flashy): Response
    {

        $flashy->primaryDark('Liste des coachs', 'http://your-awesome-link.com');



//      $requestsql = $this->getDoctrine()->getRepository(Coach::class)->mise_a_jour();



        $coaches = $this->getDoctrine()
            ->getRepository(Coach::class)
            ->findAll();


        return $this->render('coach/index.html.twig', [
            'coaches' => $coaches,
        ]);



    }


















































    /**
     * @Route("/new", name="coach_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $coach = new Coach();
        $form = $this->createForm(Coach1Type::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $file = $coach->getImageCoach();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e){

                // ... handle exception if something happ

            }
            $coach->setImageCoach( 'uploads/images/'.$fileName);




            $filee = $coach->getImageFormation();
            $fileNamee = md5(uniqid()).'.'.$filee->guessExtension();
            try {
                $filee->move(
                    $this->getParameter('images_directory'),
                    $fileNamee
                );
            } catch (FileException $ee){

                // ... handle exception if something happ

            }
            $coach->setImageFormation( 'uploads/images/'.$fileNamee);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coach);
            $entityManager->flush();


            $max=$this->getDoctrine()->getRepository(User::class)->max_id_coach();
            $requestsqlee = $this->getDoctrine()->getRepository(User::class)->insert_coach($max['id']);




            return $this->redirectToRoute('coach_index');



        }

        return $this->render('coach/new.html.twig', [
            'coach' => $coach,
            'form' => $form->createView(),
        ]);

        $flashyy->primaryDark('Ajouter un nouveau Coach','http://your-awesome-link.com');


    }









































    /**
     * @Route("/{idCoach}/edit", name="coach_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Coach $coach,FlashyNotifier $flashy): Response


    {

        $flashy->primaryDark('Liste des coachs', 'http://your-awesome-link.com');

        $form = $this->createForm(Coach1Type::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coach_index');
        }

        return $this->render('coach/edit.html.twig', [
            'coach' => $coach,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCoach}", name="coach_delete", methods={"POST"})
     */
    public function delete(Request $request, Coach $coach,FlashyNotifier $flashyy): Response
    {
        $flashyy->primaryDark('Ajouter un nouveau coacg','http://your-awesome-link.com');

        if ($this->isCsrfTokenValid('delete'.$coach->getIdCoach(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coach);
            $entityManager->flush();

        }


        return $this->redirectToRoute('coach_index');
    }














    /**
     * @Route("/pdf", name="pdf0")
     */
    public function pdf(Request $request){



// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

// Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repository=$this->getdoctrine()->getrepository(Coach::class);
        $allCoch=$repository->findAll();

// Retrieve the HTML generated in our twig file
        $html = $this->renderView('Coach/listecoachpdf.html.twig', [
            'title' => "Welcome to our PDF Test", 'Coach'=>$allCoch,
        ]);

// Load HTML to Dompdf
        $dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A1', 'portrait');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }



































}


