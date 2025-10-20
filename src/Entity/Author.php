<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'authorBooks')]
    private Collection $authorBooks;

    public function __construct()
    {
        $this->authorBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getAuthorBooks(): Collection
    {
        return $this->authorBooks;
    }

    public function addAuthorBook(Book $authorBook): static
    {
        if (!$this->authorBooks->contains($authorBook)) {
            $this->authorBooks->add($authorBook);
            $authorBook->setAuthorBooks($this);
        }

        return $this;
    }

    public function removeAuthorBook(Book $authorBook): static
    {
        if ($this->authorBooks->removeElement($authorBook)) {
            // set the owning side to null (unless already changed)
            if ($authorBook->getAuthorBooks() === $this) {
                $authorBook->setAuthorBooks(null);
            }
        }

        return $this;
    }
}
