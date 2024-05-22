<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/aleatorios', name: 'app_aleatorios_')]
class AleatoriosController extends AbstractController
{
    #[Route('/ej1', name: 'aleatorios1')]//con anotaciones
    public function index(): Response
    {
        return $this->render('aleatorios/index.html.twig', [
            'controller_name' => 'Mis Aleatorios',
        ]);
    }
//hemos creado otra ruta copiando el mismo metodo, como no puede haber 2 rutas con el mismo nombre, hemos puesto un dos para que sean diferentes.
    #[Route('/ej2', name: 'aleatorios2')]//con anotaciones
    public function index2(): Response
    {
        return $this->render('aleatorios/index.html.twig', [
            'controller_name' => 'Pagina2 Aleatorios',
        ]);
    }
    
    public function index3(): Response //Usamos YAML
    {
        return $this->render('aleatorios/index.html.twig', [
            'controller_name' => 'Pagina 3 usando el YAML',
        ]);
    }
    //pasamos parametros, se ponen entre {} y tipado en el metodo.
    #[Route('/ej4/{num1}/{num2}', name: 'aleatorios4')]
    public function index4(int $num1, int $num2): Response
    {   
        $aleatorio = rand($num1, $num2);
        return $this->render('aleatorios/index.html.twig', [
            'controller_name' => $aleatorio,
        ]);
    }


    
    public function index5(int $num1, int $num2): Response
    {   
        $aleatorio = rand($num1, $num2);
        return $this->render('aleatorios/index.html.twig', [
            'controller_name' => $aleatorio,
        ]);
    }

  

    #[Route('/menu', name: 'menu')]
    public function indexmenu(): Response
    {
        return $this->render('aleatorios/menu.twig', [
            'controller_name' => 'Menú',
        ]);
    }
    
//=============================================================================


    #[Route('/pitagoras1', name: 'aleatoriosa')]
    public function indexa(): Response
    {
        return $this->render('aleatorios/index.html.twig', [
            'controller_name' => 'pitagoras',
        ]);
    }
    #[Route('/pitagoras2', name: 'aleatoriosb')]
    public function indexb(): Response
    {
        return $this->render('aleatorios/index.html.twig', [
            'controller_name' => 'pitagoras php',
        ]);
    }
    #[Route('/newton', name: 'aleatoriosc')]
    public function indexc(): Response
    {
        return $this->render('aleatorios/index.html.twig', [
            'controller_name' => 'Newton',
        ]);
    }
    #[Route('/cabify', name: 'aleatoriosd')]
    public function indexd(): Response
    {
        return $this->render('aleatorios/index.html.twig', [
            'controller_name' => 'Cabify',
        ]);
    }
}
