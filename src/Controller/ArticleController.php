<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

  #[Route("/cms/add-article", name: "app_new_article")]
  public function addArticle(EntityManagerInterface $em): Response
  {
    // on créé un objet article par défaut
    $article = new Article();

    //ajouter les champs au formulaire
    $form = $this->createFormBuilder($article)
      ->add('title', TextType::class, ['label' => "Titre de l'article"])
      ->add('content', TextareaType::class, ['label' => "Contenu de l'article"])
      ->add('save', SubmitType::class, ['label' => "Create article"])
      ->getForm();

    // ...
    return $this->render("article/new.html.twig", [
      "form" => $form
    ]);
  }
}
