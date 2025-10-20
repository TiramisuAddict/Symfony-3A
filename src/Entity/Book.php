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

    #[ORM\ManyToOne(inversedBy: 'authorBooks')]
    private ?Author $authorBooks = null;

    /**
     * @var Collection<int, Reader>
     */
    #[ORM\ManyToMany(targetEntity: Reader::class, inversedBy: 'bookReaders')]
    private Collection $bookReaders;

    public function __construct()
    {
        $this->bookReaders = new ArrayCollection();
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

    public function getAuthorBooks(): ?Author
    {
        return $this->authorBooks;
    }

    public function setAuthorBooks(?Author $authorBooks): static
    {
        $this->authorBooks = $authorBooks;

        return $this;
    }

    /**
     * @return Collection<int, Reader>
     */
    public function getBookReaders(): Collection
    {
        return $this->bookReaders;
    }

    public function addBookReader(Reader $bookReader): static
    {
        if (!$this->bookReaders->contains($bookReader)) {
            $this->bookReaders->add($bookReader);
        }

        return $this;
    }

    public function removeBookReader(Reader $bookReader): static
    {
        $this->bookReaders->removeElement($bookReader);

        return $this;
    }
}
