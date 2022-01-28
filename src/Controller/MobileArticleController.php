<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Article;
use App\Form\Coach1Type;
use App\Repository\CoachRepository;
use App\Entity\User;
//use http\Client\Curl\User;
use MercurySeries\FlashyBundle\FlashyNotifier;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MobileArticleController extends AbstractController
{
    /**
     * @Route("/mobile/article", name="mobile_article")
     */
    public function index(): Response
    {
        return $this->render('mobile_article/index.html.twig', [
            'controller_name' => 'MobileArticleController',
        ]);
    }





    /**
     * @Route("/displayArticles", name="display_article")
     */
    public function allArticleAction()
    {

        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($article);

        return new JsonResponse($formatted);

    }




    /**
     * @Route("/deleteArticle", name="delete_article")
     */

    public function deleteArticleAction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        if($article!=null ) {
            $em->remove($article);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Article a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id article invalide.");


    }








    /**
     * @Route("/addArticle", name="add_article")
     */

    public function ajouterArticleAction(Request $request)
    {
        $article = new Article();
        $type = $request->query->get("type");
        $titre = $request->query->get("titre");
        $description = $request->query->get("description");
        $url=$request->query->get("url");
        $em = $this->getDoctrine()->getManager();
        $date = new \DateTime('now');
        $article->setType($type);
        $article->setTitre($titre);
        $article->setDescription($description);
        $article->setUrl($url);
        $article->setDate($date);
        $article->setIdPersonnel(1);
        $em->persist($article);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($article);
        return new JsonResponse($formatted);

    }




    /**
     * @Route("/updateArticle", name="update_article")
     */
    public function modifierArticleAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getManager()
            ->getRepository(Article::class)
            ->find($request->get("id"));

        $article->setType($request->get("type"));
        $article->setTitre($request->get("titre"));
        $article->setDescription($request->get("description"));


        $em->persist($article);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($article);
        return new JsonResponse("Article a ete modifiee avec success.");

    }




}
