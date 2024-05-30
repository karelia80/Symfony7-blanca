<?php

namespace App\Controller;

use App\Entity\Categorias;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categorias', name: 'app_categorias_')]
class CategoriasController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('categorias/index.html.twig', [
            'controller_name' => 'CategoriasController',
        ]);
    }

    // 01. Inserción 1 registro sin parámetros
    #[Route('/insertar', name: 'insertar')]
    public function insertar(ManagerRegistry $doctrine): Response
    {
        $gestorEntidades = $doctrine->getManager();
        $categoria = new Categorias();
        $categoria->setCategoria("Llama");

        $gestorEntidades->persist($categoria);
        $gestorEntidades->flush();

        return new Response("Categoria insertada con ID" .
            $categoria->getId());
    }

    // 02.  Inserción 1 registro con parámetros
    #[Route('/insertar/{categoria}', name: 'insertarParam')]
    public function insertarParam(
        EntityManagerInterface $gestorEntidades,
        string $categoria
    ): Response {
        $nuevaCategoria = new Categorias();
        $nuevaCategoria->setCategoria($categoria);

        $gestorEntidades->persist($nuevaCategoria);
        $gestorEntidades->flush();

        return new Response("Categoria insertada con ID" .
            $nuevaCategoria->getId());
    }

    // 03. Inserción Array sin parámetros
    #[Route('/insertar-array', name: 'insertarArray')]
    public function insertarArray(
        EntityManagerInterface $gestorEntidades
    ): Response {
        $categorias = array(
            'categoria1' => array(
                'nombre' => 'Lagartija'
            ),
            'categoria2' => array(
                'nombre' => 'Mariposa'
            ),
            'categoria3' => array(
                'nombre' => 'Capullo'
            ),
        );

        foreach ($categorias as $categoria) {
            $nuevaCategoria = new Categorias();
            $nuevaCategoria->setCategoria($categoria['nombre']);

            $gestorEntidades->persist($nuevaCategoria);
            $gestorEntidades->flush();
        }

        return new Response("Categorias insertadas");
    }
}
