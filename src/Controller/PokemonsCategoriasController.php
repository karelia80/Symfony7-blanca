<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/pokemons/insertar-con-categorias/', name: 'app_pokemons_categorias')]
class PokemonsCategoriasController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function insertarconcategorias(): Response
    {   
        

        return $this->render('pokemons_categorias/index.html.twig', [
            'controller_name' => 'PokemonsCategoriasController',
        ]);
    }
}
