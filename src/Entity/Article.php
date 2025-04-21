<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]
  private ?int $id = null;

  #[ORM\Column(type: 'string', length: 255)]
  #[Assert\NotBlank(message: 'The title cannot be blank.')]
  #[Assert\Length(
    max: 255,
    maxMessage: 'The title cannot be longer than {{ limit }} characters.'
  )]
  private ?string $title = null;

  #[ORM\Column(type: 'text')]
  #[Assert\NotBlank(message: 'The content cannot be blank.')]
  private ?string $content = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $createdAt = null;

  // [TODO] changer la requette pour plus de sécurité
  // attention le mode eager récupère toutes les info du user même son mot de pass hashé
  #[ORM\ManyToOne(inversedBy: "articles", fetch: "EAGER")]
  #[ORM\JoinColumn(nullable: false)]
  private ?User $author = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): static
  {
    $this->title = $title;

    return $this;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(?string $content): static
  {
    $this->content = $content;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeImmutable $createdAt): static
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function getAuthor(): ?User
  {
    return $this->author;
  }

  public function setAuthor(?User $author): static
  {
    $this->author = $author;

    return $this;
  }
}
