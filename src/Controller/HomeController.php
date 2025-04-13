<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class HomeController extends AbstractController
{
  #[Route("/", name: "app_home")]
  public function index(): Response
  {
    return $this->render("home/index.html.twig", []);
  }

  //controle de l'acèss aux données
  //method 1 access controll dans le security.yaml
  #[Route("/private", name: "app_private")]
  public function private(): Response
  {
    return $this->render("home/private.html.twig", []);
  }

  //method 21 avec method deny
  #[Route("/private2", name: "app_private2")]
  public function private2(): Response
  {
    //Méthode fournie par Abstract controller
    $this->denyAccessUnlessGranted("ROLE_USER");
    return $this->render("home/private.html.twig", []);
  } // existe aussi 'Is_Autheticated'

  //method 2B
  //avec attribut
  #[IsGranted("ROLE_ADMIN")]
  #[Route("/private3", name: "app_private3")]
  public function private3(): Response
  {
    return $this->render("home/private.html.twig", []);
  }
}
