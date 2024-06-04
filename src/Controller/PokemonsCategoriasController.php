<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Entity\Pokemons;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/pokemons', name: 'app_pokemons_categorias')]
class PokemonsCategoriasController extends AbstractController
{
    #[Route('/insertar-con-categorias/{categoria}/{nombrepokemon}/{altura}/{peso}/{sexo}', 
    name: 'insertarconcategorias')]
    public function insertarconcategorias(  EntityManagerInterface $gestorEntidades,
    string $categoria, string $nombrepokemon,int $altura, float $peso,bool $sexo): Response
    {   $nuevaCategoria = new Categorias();
        $nuevaCategoria->setCategoria($categoria);

        $gestorEntidades->persist($nuevaCategoria);
        $gestorEntidades->flush();

        $pokemon = new Pokemons();
        $pokemon->setNombre($nombrepokemon);
        $pokemon->setAltura($altura);
        $pokemon->setPeso($peso);
        $pokemon->setSexo($sexo);
        $pokemon->setIdCategoria($nuevaCategoria);
        $gestorEntidades->persist($pokemon);
        $gestorEntidades->flush();

        $pokemonsRepository = $gestorEntidades->getRepository(Pokemons::class);
        $categoriasRepository = $gestorEntidades->getRepository(Categorias::class);
 
        $pokemon = $pokemonsRepository->findAll();
        $categoria = $categoriasRepository->findAll();

        return $this->render('pokemons_categorias/index.html.twig', [
             'pokemons' => $pokemon,
            'categorias' => $categoria,

        ]);
    }
}
