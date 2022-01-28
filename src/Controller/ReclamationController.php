<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="reclamation_index", methods={"GET"})
     */
    public function index(): Response
    {

        // $requestsql  = $this->getDoctrine()->getRepository(Reclamation::class)->checkDateReclam1Day();


        $reclamations = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findAll();

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    /**
     * @Route("/new", name="reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reclamation = new Reclamation();
        $reclamation->setDaterec(new \DateTime('now'));
        $reclamation->setStatusrec(('non traite'));
        $reclamation->setDatetraitement(null);


        $reclamation->setIdjoueur('107');
        $reclamation->setNomjoueur('ouerghi');
        $reclamation->setPrenomjoueur('aymen');
        $reclamation->setEmailjoueur('aymen@gmail.com');
        $reclamation->setTljoueur('25961798');

        // $reclamation->getIdjoueur('107');
        // $reclamation->getNomjoueur('ouerghi');
        // $reclamation->getPrenomjoueur('aymen');
        // $reclamation->getEmailjoueur('aymen@gmail.com');
        // $reclamation->getTljoueur('25961798');

        

        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        	$file = $form->get('sujetrec')->getData();

            if($file == "Application" || $file == "Autre" )
            {
                $reclamation->setNomprenomcoach(Null);
            } 

            $reclamation->setDescriptionrec($this->filterwords($reclamation->getDescriptionrec()));
            // On récupère les images transmises
            $file = $form->get('imgrec')->getData();
            if ($file !== null) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {

                    // ... handle exception if something happ
                    
                }
                $reclamation->setImgrec($fileName);
            }

            // if($form->get('sujetrec')->getData() == 'Coach')
            // {

            //     $form->add('nomprenomcoach', ChoiceType::class, [

            //         'multiple' => false,
            //         'choices' =>
    
            //         $this->userRepository->createQueryBuilder('u')->select("CONCAT(u.nomCoach,' ',u.prenomCoach) as id")->getQuery()->getResult(),
            //         'choice_label' => function ($choice) {
            //             return $choice;
            //         },
            //     ]);
                
            // }

            // yassindaboussi@yandex.com
       
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
        dd($reclamation);
    }

    /**
     * @Route("/{idrec}", name="reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{idrec}/edit", name="reclamation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reclamation $reclamation): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('sujetrec')->getData();

            if($file == "Application" || $file == "Autre" )
            {
                $reclamation->setNomprenomcoach(Null);
            } 
        	
            // On récupère les images transmises
            $file = $form->get('imgrec')->getData();
            if ($file !== null) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {

                    // ... handle exception if something happ
                    
                }
                $reclamation->setImgrec($fileName);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/r/search_rec", name="search_rec", methods={"GET"})
     */
    public function search_rec(Request $request,NormalizerInterface $Normalizer,ReclamationRepository $reclamationRepository ): Response
    {
       
        $requestString=$request->get('searchValue');
        $requestString2=$request->get('searchValue2');
        $requestString3=$request->get('orderid');
       
      //   dump($requestString);
      //  dump($requestString2);
        $reclamations = $reclamationRepository->findReclamationsBySujet($requestString,$requestString2,$requestString3);
     //   dump($reclamations);
        $jsoncontentc =$Normalizer->normalize($reclamations,'json',['groups'=>'posts:read']);
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
     * @Route("/r/reclamation_stat", name="reclamation_stat", methods={"GET"})
     */
    public function reclamation_stat(ReclamationRepository $reclamationRepository): Response
    {
        $nbrs[]=Array();
        
            $e1=$reclamationRepository->find_Nb_Rec_Par_Status("traite");
            dump($e1);
            $nbrs[]=$e1[0][1];
            $e2=$reclamationRepository->find_Nb_Rec_Par_Status("non traite");
            dump($e2);
            $nbrs[]=$e2[0][1];

            dump($nbrs);
        reset($nbrs);
       dump(reset($nbrs));
        $key = key($nbrs);
        dump($key);
        dump($nbrs[$key]);

        unset($nbrs[$key]);
      
        $nbrss=array_values($nbrs);
        dump(json_encode($nbrss));
        
        return $this->render('reclamation/stat.html.twig', [
            'nbr' => json_encode($nbrss),
        ]);
    }
    
    /**
     * @Route("/{idrec}", name="reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reclamation->getIdrec(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reclamation_index');
    }

    function filterwords($text){
        $filterWords = array('fuck','pute','bitch');
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }


    /**
     *@Route("/pdf/reclam.pdf",name="pdf_index", methods={"GET"})
     */
    public function pdfReclamation(ReclamationRepository $ReclamationRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reclamation/pdf.html.twig', [
            'reclamation' =>$ReclamationRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A2', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }


    public function getData() :array
    {
        /**
         * @var $Reclamation rec[]
         */
        $list = [];
        // $reclam = $this->entityManager->getRepository(Reclamation::class)->findAll();
        $reclam = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();

        foreach ($reclam as $rec) {
            $list[] = [
                $rec->getIdrec(),
                $rec->getSujetrec(),
                $rec->getDescriptionrec(),
                $rec->getStatusrec(),
                $rec->getDaterec(),
                $rec->getDatetraitement(),
                $rec->getNomprenomcoach(),
                $rec->getImgrec(),
                $rec->getIdjoueur(),
                $rec->getNomjoueur(),
                $rec->getPrenomjoueur(),
                $rec->getEmailjoueur(),
                $rec->getTljoueur()
            ];
        }
        return $list;
    }

    /**
     * @Route("/excel/export",  name="export")
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Reclamation List');

        $sheet->getCell('A1')->setValue('Idrec');
        $sheet->getCell('B1')->setValue('SujetRec');
        $sheet->getCell('C1')->setValue('Description');
        $sheet->getCell('D1')->setValue('Statusrec');
        $sheet->getCell('E1')->setValue('Daterec');
        $sheet->getCell('F1')->setValue('Datetraitement');
        $sheet->getCell('G1')->setValue('Coach');
        $sheet->getCell('H1')->setValue('Imgrec');
        $sheet->getCell('I1')->setValue('Idjoueur');
        $sheet->getCell('J1')->setValue('Nomjoueur');
        $sheet->getCell('K1')->setValue('Prenomjoueur');
        $sheet->getCell('L1')->setValue('Emailjoueur');
        $sheet->getCell('M1')->setValue('Tljoueur');


        // Increase row cursor after header write
        $sheet->fromArray($this->getData(),null, 'A2', true);
        $writer = new Xlsx($spreadsheet);
        // $writer->save('ss.xlsx');
        $writer->save('Reclam'.date('m-d-Y_his').'.xlsx');
        return $this->redirectToRoute('reclamation_index');

    }
    

}
