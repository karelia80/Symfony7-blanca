<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PokemonsCategoriasController extends AbstractController
{
    #[Route('/pokemons/insertar-con-categorias/', name: 'app_pokemons_categorias')]
    public function insertarconcategorias(): Response
    {   
        

        return $this->render('pokemons_categorias/index.html.twig', [
            'controller_name' => 'PokemonsCategoriasController',
        ]);
    }
}
