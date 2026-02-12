<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $synopsis = null;

    #[ORM\Column]
    private ?int $releaseYear = null;

    /**
     * @var Collection<int, Platforme>
     */
    #[ORM\ManyToMany(targetEntity: Platforme::class, inversedBy: 'films')]
    private Collection $platformes;

    public function __construct()
    {
        $this->platformes = new ArrayCollection();
    }

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

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): static
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    /**
     * @return Collection<int, Platforme>
     */
    public function getPlatformes(): Collection
    {
        return $this->platformes;
    }

    public function addPlatforme(Platforme $platforme): static
    {
        if (!$this->platformes->contains($platforme)) {
            $this->platformes->add($platforme);
        }

        return $this;
    }

    public function removePlatforme(Platforme $platforme): static
    {
        $this->platformes->removeElement($platforme);

        return $this;
    }
}
