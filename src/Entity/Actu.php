<?php

namespace App\Entity;

use App\Repository\ActuRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActuRepository::class)]
class Actu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text_content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $publication_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $images = null;

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

    public function getTextContent(): ?string
    {
        return $this->text_content;
    }

    public function setTextContent(string $text_content): static
    {
        $this->text_content = $text_content;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(\DateTimeInterface $publication_date): static
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): static
    {
        $this->images = $images;

        return $this;
    }
}
