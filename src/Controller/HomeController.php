<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
