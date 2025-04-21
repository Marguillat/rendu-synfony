<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

  #[Route("/articles/{id}", name: "app_article", requirements: ["id" => "\d+"])]
  public function articles(EntityManagerInterface $em, int $id): Response
  {
    $article = $em->getRepository(Article::class)->find($id);

    return $this->render("article/unique.html.twig", [
      "article" => $article,
    ]);
  }

  #[Route("/articles/{id}/edit", name: "app_article_edit")]
  public function editArticle(EntityManagerInterface $em, int $id, Request $request): Response
  {
    $article = $em->getRepository(Article::class)->find($id);

    if (!$article) {
      throw $this->createNotFoundException('Article not found');
    }

    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);
    // Si le formulaire est soumis et est valide, on peut traiter les données et persister les modifications dans la base de données
    // Si le formulaire n'est pas soumis ou n'est pas valide, on affiche le formulaire avec les données de l'article existant

    if ($form->isSubmitted() && !$form->isValid()) {
      dump($form->getErrors(true, false)); // Affiche toutes les erreurs du formulaire
      die();
    }

    if ($form->isSubmitted() && $form->isValid()) {
      // Persiste les modifications dans la base de données
      $em->flush();

      // Redirige vers la page de l'article ou une autre page
      return $this->redirectToRoute('app_article', ['id' => $article->getId()]);
    }

    return $this->render("article/edit.html.twig", [
      "article" => $article,
      "form" => $form->createView(),
    ]);
  }

  #[Route("/articles/{id}/delete", name: "app_article_delete")]
  public function deleteArticle(EntityManagerInterface $em, int $id): Response
  {
    $article = $em->getRepository(Article::class)->find($id);

    if (!$article) {
      throw $this->createNotFoundException('Article not found');
    }

    $em->remove($article);
    $em->flush();

    return $this->redirectToRoute('app_articles');
  }
}
