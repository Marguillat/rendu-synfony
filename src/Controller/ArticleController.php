<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
  #[Route("/articles", name: "app_articles")]
  public function index(EntityManagerInterface $em): Response
  {
    $articles = $em->getRepository(Article::class)->findAll();

    return $this->render("article/list.html.twig", [
      "articles_list" => $articles,
    ]);
  }

  #[Route("/articles/{id}", name: "app_article")]
  public function articles(EntityManagerInterface $em, int $id): Response
  {
    $article = $em->getRepository(Article::class)->find($id);

    return $this->render("article/unique.html.twig", [
      "article" => $article,
    ]);
  }
}
