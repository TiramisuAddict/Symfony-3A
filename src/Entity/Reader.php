<?php

namespace App\Entity;

use App\Repository\ReaderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReaderRepository::class)]
class Reader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'bookReaders')]
    private Collection $bookReaders;

    public function __construct()
    {
        $this->bookReaders = new ArrayCollection();
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

    /**
     * @return Collection<int, Book>
     */
    public function getBookReaders(): Collection
    {
        return $this->bookReaders;
    }

    public function addBookReader(Book $bookReader): static
    {
        if (!$this->bookReaders->contains($bookReader)) {
            $this->bookReaders->add($bookReader);
            $bookReader->addBookReader($this);
        }

        return $this;
    }

    public function removeBookReader(Book $bookReader): static
    {
        if ($this->bookReaders->removeElement($bookReader)) {
            $bookReader->removeBookReader($this);
        }

        return $this;
    }
}
