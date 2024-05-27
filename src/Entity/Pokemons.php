<?php

namespace App\Entity;

use App\Repository\PokemonsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonsRepository::class)]
class Pokemons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $altura = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $peso = null;

    #[ORM\Column]
    private ?bool $sexo = null;

    #[ORM\ManyToOne(inversedBy: 'pokemons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorias $idCategoria = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getAltura(): ?int
    {
        return $this->altura;
    }

    public function setAltura(int $altura): static
    {
        $this->altura = $altura;

        return $this;
    }

    public function getPeso(): ?string
    {
        return $this->peso;
    }

    public function setPeso(string $peso): static
    {
        $this->peso = $peso;

        return $this;
    }

    public function isSexo(): ?bool
    {
        return $this->sexo;
    }

    public function setSexo(bool $sexo): static
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getIdCategoria(): ?Categorias
    {
        return $this->idCategoria;
    }

    public function setIdCategoria(?Categorias $idCategoria): static
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }
}
