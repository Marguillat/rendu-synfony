<?php

// src/Entity/Task.php
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
class Task
{
  // les champs task et dueDate sont vérifié de manière déclarative par les attributs php et les validators
  #[Assert\NotBlank]
  protected string $task;

  // les champs task et dueDate sont vérifié de manière déclarative par les attributs php et les validators
  #[Assert\NotBlank]
  #[Assert\Type(\DateTimeInterface::class)]
  protected ?\DateTimeInterface $dueDate;

  public function getTask(): string
  {
    return $this->task;
  }

  public function setTask(string $task): void
  {
    $this->task = $task;
  }

  public function getDueDate(): ?\DateTimeInterface
  {
    return $this->dueDate;
  }

  public function setDueDate(?\DateTimeInterface $dueDate): void
  {
    $this->dueDate = $dueDate;
  }
}
