<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function Symfony\Component\Clock\now;

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

  #[Route("/articles/{id}", name: "app_article")]
  public function articles(EntityManagerInterface $em, int $id): Response
  {
    $article = $em->getRepository(Article::class)->find($id);

    return $this->render("article/unique.html.twig", [
      "article" => $article,
    ]);
  }

  #[Route("/cms/add-article", name: "app_new_article")]
  public function addArticle(Request $request, EntityManagerInterface $em): Response
  {

    // Récupère le user depuis la session
    $user = $this->security->getUser();

    // on créé un objet article par défaut
    $article = new Article();

    //ajouter les champs au formulaire
    $form = $this->createFormBuilder($article)
      ->add('title', TextType::class, ['label' => "Titre de l'article"])
      ->add('content', TextareaType::class, ['label' => "Contenu de l'article"])
      ->add('save', SubmitType::class, ['label' => "Créer le nouvel article"])
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
      return $this->redirectToRoute('app_articles');
    }
    return $this->render("article/new.html.twig", [
      "form" => $form,
    ]);
  }
}
