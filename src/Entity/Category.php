<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'categories')]
    private Collection $boardgames;

    public function __construct()
    {
        $this->boardgames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getBoardgames(): Collection
    {
        return $this->boardgames;
    }

    public function addBoardgame(Game $boardgame): self
    {
        if (!$this->boardgames->contains($boardgame)) {
            $this->boardgames->add($boardgame);
            $boardgame->addCategory($this);
        }

        return $this;
    }

    public function removeBoardgame(Game $boardgame): self
    {
        if ($this->boardgames->removeElement($boardgame)) {
            $boardgame->removeCategory($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
