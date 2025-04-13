<?php
// src/Form/Type/TaskType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

// abstractType qui permet de créer des types de forms dans leur propre classe
class TaskType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add("task", TextType::class, [
        "constraints" => [new Length(["max" => 10])],
      ])
      ->add("dueDate", DateType::class)
      ->add("save", SubmitType::class);
  }
}
