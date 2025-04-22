<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
  /**
   * Permet d'accéder à la partie sécurité et session dans les pages articles
   * @var Security
   */
  private $security;
  public function __construct(Security $security)
  {
    $this->security = $security;
  }

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

  #[Route("/cms/add-article", name: "app_new_article")]
  public function addArticle(
    Request $request,
    EntityManagerInterface $em
  ): Response {
    // Récupère le user depuis la session
    $user = $this->security->getUser();

    // on créé un objet article par défaut
    $article = new Article();

    //ajouter les champs au formulaire
    $form = $this->createFormBuilder($article)
      ->add("title", TextType::class, ["label" => "Titre de l'article"])
      ->add("content", TextareaType::class, ["label" => "Contenu de l'article"])
      ->add("save", SubmitType::class, ["label" => "Créer le nouvel article"])
      ->getForm();

    // Manipule le formulaire envoyé
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      // $form->getData() holds the submitted values
      // but, the original `$article` variable has also been updated

      $article->setAuthor($user);
      $article->setCreatedAt(new \DateTimeImmutable());

      $em->persist($article);
      // ne pas oublier de tirer la chasse avant de partir
      $em->flush();
      return $this->redirectToRoute("app_articles");
    }
    return $this->render("article/new.html.twig", [
      "form" => $form,
    ]);
  }

  #[Route("/cms/articles/{id}/edit", name: "app_article_edit")]
  public function editArticle(
    EntityManagerInterface $em,
    int $id,
    Request $request
  ): Response {
    $article = $em->getRepository(Article::class)->find($id);
    // Récupère le user depuis la session
    $sessionUser = $this->security->getUser();
    $dbUser = $em
      ->getRepository(User::class)
      ->findOneBy(["email" => $sessionUser->getUserIdentifier()]);

    if (!$article) {
      throw $this->createNotFoundException("Article not found");
    }

    if ($dbUser->getId() != $article->getAuthor()->getId()) {
      if (!in_array("ROLE_ADMIN", $dbUser->getRoles())) {
        throw $this->createAccessDeniedException(
          "Vous n'êtes pas l'auteur de cet article, vous ne pouvez donc pas le modifier"
        );
      }
    }

    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);
    // Si le formulaire est soumis et est valide, on peut traiter les données et persister les modifications dans la base de données
    // Si le formulaire n'est pas soumis ou n'est pas valide, on affiche le formulaire avec les données de l'article existant

    if ($form->isSubmitted() && !$form->isValid()) {
      dump($form->getErrors(true, false)); // Affiche toutes les erreurs du formulaire
      die();
    }

    if ($form->isSubmitted()) {
      dump($form->getData());
      // Persiste les modifications dans la base de données
      $em->flush();

      // Redirige vers la page de l'article ou une autre page
      return $this->redirectToRoute("app_article", ["id" => $article->getId()]);
    }

    return $this->render("article/edit.html.twig", [
      "article" => $article,
      "form" => $form->createView(),
    ]);
  }

  #[Route("/cms/articles/{id}/delete", name: "app_article_delete")]
  public function deleteArticle(EntityManagerInterface $em, int $id): Response
  {
    $article = $em->getRepository(Article::class)->find($id);

    $sessionUser = $this->security->getUser();
    $dbUser = $em
      ->getRepository(User::class)
      ->findOneBy(["email" => $sessionUser->getUserIdentifier()]);

    if (!$article) {
      throw $this->createNotFoundException("Article not found");
    }

    if (
      $dbUser->getId() != $article->getAuthor()->getId() &&
      !in_array("ROLE_ADMIN", $dbUser->getRoles())
    ) {
      throw $this->createAccessDeniedException(
        "Vous ne pouvez pas supprimer un article qui ne vous appartient pas"
      );
    }

    $em->remove($article);
    $em->flush();

    return $this->redirectToRoute("app_articles");
  }
}
