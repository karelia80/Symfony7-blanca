<?php

namespace App\Entity;

use App\Repository\CategoriasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriasRepository::class)]
class Categorias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $categoria = null;

    /**
     * @var Collection<int, Pokemons>
     */
    #[ORM\OneToMany(targetEntity: Pokemons::class, mappedBy: 'idCategoria')]
    private Collection $pokemons;

    public function __construct()
    {
        $this->pokemons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection<int, Pokemons>
     */
    public function getPokemons(): Collection
    {
        return $this->pokemons;
    }

    public function addPokemon(Pokemons $pokemon): static
    {
        if (!$this->pokemons->contains($pokemon)) {
            $this->pokemons->add($pokemon);
            $pokemon->setIdCategoria($this);
        }

        return $this;
    }

    public function removePokemon(Pokemons $pokemon): static
    {
        if ($this->pokemons->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getIdCategoria() === $this) {
                $pokemon->setIdCategoria(null);
            }
        }

        return $this;
    }
}
