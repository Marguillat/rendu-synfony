<?php

// src/Controller/TaskController.php
namespace App\Controller;

use App\Entity\Task;
//import du type de form
use App\Form\TaskType;
//
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
  #[Route("/edit-task", name: "app_edit_task")]
  public function new(Request $request): Response
  {
    // creates a task object and initializes some data for this example
    $task = new Task(); //nouvelle entité
    $task->setTask("Write a blog post");
    $task->setDueDate(new \DateTimeImmutable("tomorrow"));

    // créer le form du type TaskType avec les données de $task
    $form = $this->createForm(TaskType::class, $task);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      // traitement du formulaire

      $task = $form->getData();
    }

    return $this->render("task/index.html.twig", [
      "form" => $form,
    ]);
  }
}
