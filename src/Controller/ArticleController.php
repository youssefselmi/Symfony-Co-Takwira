<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Snipe\BanBuilder\CensorWords;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Twilio\Rest\Client;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    private $twilio;

public function __construct(Client $twilio) {
   $this->twilio = $twilio;

 }
    /**
     * @Route("/home", name="home")
     */
    public function home(): Response
    {
        return $this->render('article/home.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/front", name="front")
     */
    public function homef(Request $request,PaginatorInterface $paginator,ArticleRepository $repository,FlashyNotifier $flashy): Response
    {
        $date = new \DateTime('now');
        $notification = "";
        $count=0;
        $posts = $repository->findAll();
        foreach ($posts as $article){
            $diff = date_diff($article->getDate() ,$date);
            if ($diff->d==0){
                $count++;
            }
        }
        $notification .= "Le nombre des articles ajouté aujourd'hui est : " .$count;
        $flashy->success($notification);



        $donnees =$repository->triedecroissant();
        $articles=$paginator->paginate(
            $donnees,// Requête contenant les données à paginer (ici les publications)
            $request->query->getInt('page',1),// Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            8   // Nombre de résultats par page
        );
        return $this->render('article/indexf.html.twig', [
            'articles' => $articles,
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/", name="article_index")
     */
    public function index(Request $request,ArticleRepository $repository): Response
    {
        $search = $request->query->get("search");
        $articles = $repository->findAllWithSearch($search);
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/new", name="article_new")
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('url')->getData();
            // this condition is needed because the 'brochure' field is not required
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('articles_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'image' property to store the PDF file name
                // instead of its contents
                $article->setUrl($newFilename);
            }


            $article->setIdPersonnel(1);
            $article->setDate(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $sender = $this->getParameter('twilio_number');
            $message = $this->twilio->messages->create(
                '+21652117548', // Send text to this number
                array(
                    'from' => $sender, // My Twilio phone number
                    'body' => 'Votre article a été ajouté avec succés'
                )
            );

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        $commentaires= $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->findByIdArticle($article->getId());

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentaires' => $commentaires
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('url')->getData();
            // this condition is needed because the 'brochure' field is not required
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('articles_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'image' property to store the PDF file name
                // instead of its contents
                $article->setUrl($newFilename);
                $article->setDate(new \DateTime('now'));


                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('article_index');
            }
            else{

                $article->setDate(new \DateTime('now'));


                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('article_index');

            }

        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/deleteArticle", name="article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/article/front/{id}", name="article_front", methods={"GET","POST"})
     */
    public function show2(Article $article,Request $request): Response
    {
        $commentaires= $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->findByIdArticle($article->getId());
        $commentaire = new Commentaire();
        $commentaire->setIdArticle($article->getId());
        $commentaire->setIdJoueur(1);
        $commentaire->setDate(new \DateTime('now'));
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $censor = new CensorWords;
            $langs = array('fr','it','en-us','en-uk','de','es');
            $badwords = $censor->setDictionary($langs);
            $censor->setReplaceChar("*");
            $string = $censor->censorString($commentaire->getContenu());
            $commentaire->setContenu($string['clean']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('front');
        }
        return $this->render('article/showf.html.twig', [
            'article' => $article,
            'commentaire' => $commentaire,
            'commentaires' => $commentaires,
            'formC' => $form->createView(),
        ]);
    }

}
