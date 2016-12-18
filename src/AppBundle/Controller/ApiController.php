<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Serializer\Normalizer\CategoryNormalizer;
use AppBundle\Serializer\Normalizer\UserNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends Controller
{
    /**
     * @Route("/api/articles.json", name="api_articles")
     */
    public function articlesAction(Request $request)
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->findBy(
            array(),
            array('date' => 'desc')
        );

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function($object)
        {
            return $object->getTitle();
        });

        $normalizerUser = new UserNormalizer();
        $normalizerCategory = new CategoryNormalizer();

        $serializer = new Serializer(array(new DateTimeNormalizer(), $normalizerUser, $normalizerCategory, $normalizer), array($encoder));

        $response = new Response();
        $response->setContent($serializer->serialize($articles, 'json', ['json_encode_options' => JSON_PRETTY_PRINT]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/article/{id}.json", name="api_article", requirements={"id": "\d+"})
     */
    public function articleAction(Request $request, Article $article)
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function($object)
        {
            return $object->getTitle();
        });

        $normalizerUser = new UserNormalizer();
        $normalizerCategory = new CategoryNormalizer();

        $serializer = new Serializer(array(new DateTimeNormalizer(), $normalizerUser, $normalizerCategory, $normalizer), array($encoder));

        $response = new Response();
        $response->setContent($serializer->serialize($article, 'json', ['json_encode_options' => JSON_PRETTY_PRINT]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/categories.json", name="api_categories")
     */
    public function categoriesAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        $encoder = new JsonEncoder();
        $normalizerCategory = new CategoryNormalizer();

        $serializer = new Serializer(array($normalizerCategory), array($encoder));

        $response = new Response();
        $response->setContent($serializer->serialize($categories, 'json', ['json_encode_options' => JSON_PRETTY_PRINT]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/category/{id}.json", name="api_category", requirements={"id": "\d+"})
     */
    public function categoryAction(Request $request, Category $category)
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function($object)
        {
            return $object->getTitle();
        });

        $normalizerUser = new UserNormalizer();
        $normalizerCategory = new CategoryNormalizer();

        $serializer = new Serializer(array(new DateTimeNormalizer(), $normalizerUser, $normalizerCategory, $normalizer), array($encoder));

        $response = new Response();
        $response->setContent($serializer->serialize($category->getArticles(), 'json', ['json_encode_options' => JSON_PRETTY_PRINT]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}