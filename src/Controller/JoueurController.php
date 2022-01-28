<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Entity\User;
use App\Form\JoueurType;
use App\Repository\JoueurRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;


/**
 * @Route("/joueur")
 */
class JoueurController extends AbstractController
{
    /**
     * @Route("", name="joueur_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator , FlashyNotifier $flashy): Response
    {

        $flashy->primaryDark('Liste des Joueurs', 'http://your-awesome-link.com');

        // Retrieve the HTML generated in our twig file

        $requestsql = $this->getDoctrine()->getRepository(Joueur::class)->mise_a_jour();



        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'

        $donnees = $this->getDoctrine()
            ->getRepository(Joueur::class)
            ->findBy([],['idJoueur' => 'desc']);

        $joueurs = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        return  $this->render('joueur/index.html.twig', [
            'joueurs' => $joueurs,
        ]);
    }

    /**
     * @Route("/pdfyasmine", name="pdfyasmine",  methods={"GET","POST"})

     */
    public function pdf(Request $request)
    {

// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

// Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repository=$this->getdoctrine()->getrepository(Joueur::class);
        $allJoueur=$repository->findAll();

// Retrieve the HTML generated in our twig file
        $html = $this->renderView('joueur/pdf.html.twig', [
            'title' => "Welcome to our PDF Test", 'joueur'=>$allJoueur,
        ]);

// Load HTML to Dompdf
        $dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A2', 'portrait');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
        $pdfOptions->set('isRemoteEnabled', true);

    }
    /**
     * @Route("/new", name="joueur_new", methods={"GET","POST"})
     */
    public function new(Request $request,ValidatorInterface $validator, \Swift_Mailer $mailer ,FlashyNotifier $flashy): Response
    {
        $joueur = new Joueur();
        $errors=null;
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $errors= $validator->validate($joueur);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $contact=$form->getData();



            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('co.takwira.tunisie@gmail.com')
                ->setTo($joueur->getAdresseMail())
            ->setBody('hello')
                ->setBody($this->renderView('emails/email.php.twig', compact('joueur')), 'text/html')

                ->attach(\Swift_Attachment::fromPath('C:\Users\ASUS\Downloads\Documents\aaa.png'));
            $mailer->send($message);




            $flashy->primaryDark('joueur ajouté avec succés', 'http://your-awesome-link.com');

            $this->addFlash('message', 'le message à bien été envoyé');


            $re=$request->get('dateNaissance');
            $joueur->setDateNaissance(new \DateTime($re));

            $file = $joueur->getImage();

            $aujourdhui = date("Y-m-d");
            $diff = date_diff($joueur->getDateNaissance(), date_create($aujourdhui));
            $joueur->setAgeJoueur( $diff->format('%y'));




            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e){

                // ... handle exception if something happ

            }
            if($joueur->getAgeJoueur()<=18)
            {$joueur->setCategorie("junior");}
            else {$joueur->setCategorie("sunior");}
            $entityManager = $this->getDoctrine()->getManager();
            $joueur->setImage( $fileName);
          //  $joueur->setDateNaissance(DateTime)($request->get('dateNaissance'));
           // $joueur->setNomJoueur((string)$request->get('nomJoueur'));

            $entityManager->persist($joueur);
            $entityManager->flush();
            $max=$this->getDoctrine()->getRepository(User::class)->max_id_joueur();
           // var_dump($max['id']);
            $requestsqlee = $this->getDoctrine()->getRepository(User::class)-> insert_user($max['id']);


            return $this->redirectToRoute('joueur_index');
        }

        return $this->render('joueur/new.html.twig', [
            'joueur' => $joueur,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/{idJoueur}", name="joueur_show", methods={"GET"})
     */
    public function show(Joueur $joueur): Response
    {
        return $this->render('joueur/show.html.twig', [
            'joueur' => $joueur,
        ]);
    }

    /**
     * @Route("/{idJoueur}/edit", name="joueur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Joueur $joueur): Response
    {
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $re=$request->get('dateNaissance');
            $joueur->setDateNaissance(new \DateTime($re));
            $file = $joueur->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e){

                // ... handle exception if something happ

            }
            $joueur->setImage( $fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('joueur_index');
        }

        return $this->render('joueur/edit.html.twig', [
            'joueur' => $joueur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idJoueur}", name="joueur_delete", methods={"POST"})
     */
    public function delete(Request $request, Joueur $joueur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$joueur->getIdJoueur(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($joueur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('joueur_index');
    }









    /**
     * @Route("/j/search_joueur", name="search_joueure", methods={"GET"})
     */
    public function search_produit(Request $request,NormalizerInterface $Normalizer,JoueurRepository $joueurRepository ): Response
    {

        $requestString=$request->get('searchValue');
        $requestString2=$request->get('searchValue2');


        //   dump($requestString);
        //  dump($requestString2);
        $joueurs =$joueurRepository->findProduitsBySujet($requestString,$requestString2);
        //   dump($reclamations);
        $jsoncontentc =$Normalizer->normalize($joueurs,'json',['groups'=>'posts:read']);
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










}
