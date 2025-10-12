<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $publicationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enabled = null;

    #[ORM\ManyToOne(inversedBy: 'booksList')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $authorbook = null;

    /**
     * @var Collection<int, Reader>
     */
    #[ORM\ManyToMany(targetEntity: Reader::class)]
    private Collection $book_reader;

    public function __construct()
    {
        $this->book_reader = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPublicationDate(): ?\DateTime
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?\DateTime $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getEnabled(): ?string
    {
        return $this->enabled;
    }

    public function setEnabled(?string $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getAuthorbook(): ?Author
    {
        return $this->authorbook;
    }

    public function setAuthorbook(?Author $authorbook): static
    {
        $this->authorbook = $authorbook;

        return $this;
    }

    /**
     * @return Collection<int, Reader>
     */
    public function getBookReader(): Collection
    {
        return $this->book_reader;
    }

    public function addBookReader(Reader $bookReader): static
    {
        if (!$this->book_reader->contains($bookReader)) {
            $this->book_reader->add($bookReader);
        }

        return $this;
    }

    public function removeBookReader(Reader $bookReader): static
    {
        $this->book_reader->removeElement($bookReader);

        return $this;
    }
}
