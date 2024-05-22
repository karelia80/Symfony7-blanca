<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class persona // hago una clase persona
{
    public string $nombre;
    public int $edad;
    public bool $sexo;

    public function __construct(string $nombre, int $edad, bool $sexo)
    {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->sexo = $sexo;
    }
}

class TwigController extends AbstractController
{
    #[Route('/twig/{nombre}/{edad}/{sexo}', name: 'app_twig')]//pasamos los parametros
    public function index(string $nombre, int $edad, bool $sexo): Response//los parametros tipado en el metodo
    {
        $persona = new Persona($nombre,$edad,$sexo);//me creo una persona

        return $this->render('twig/index.html.twig', [
            'controller_name' => 'TwigController',
            "TwigPersona" => $persona,
        ]);
    }
}
// EJEMPLO para probar antes de pasarla a twig: localhost:8000/twig/BLanca Soler/43/1