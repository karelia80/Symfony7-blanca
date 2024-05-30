<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Entity\Pokemons;
use App\Repository\PokemonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pokemons', name: 'app_pokemons_')]
class PokemonsController extends AbstractController
{

    //Plantilla para metodos
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('pokemons/index.html.twig', [
            'controller_name' => 'PokemonsController',
        ]);
    }
    //4 Insertar 1 registro con parametros y FK
    #[Route(
        '/insertar/{cat}/{nombre}/{altura}/{peso}/{sexo}',
        name: 'insertarParams'
    )]
    public function insertarParams(
        int $cat,
        string $nombre,
        int $altura,
        float $peso,
        bool $sexo,
        ManagerRegistry $doctrine
    ): Response {
        $gestorEntidades = $doctrine->getManager();

        $pokemon = new Pokemons();
        $pokemon->setNombre($nombre);
        $pokemon->setAltura($altura);
        $pokemon->setPeso($peso);
        $pokemon->setSexo($sexo);

        // Gentileza Juan Carlos ;)
        //Para las claves foraneas se introduce el objeto ENTERO
        $categoria = new Categorias();

        //Optengo el repositorio de categorias
        $repoCategorias = $gestorEntidades->getRepository(Categorias::class);
        //Saco el objeto completo
        $categoria = $repoCategorias->find($cat);
        $pokemon->setIdCategoria($categoria);

        $gestorEntidades->persist($pokemon);
        $gestorEntidades->flush();

        return new Response("Pokemon insertado con ID: " . $pokemon->getid());
    }
    // 05 Consulta COMPLETA (findAll)
    #[Route('/verPokemons', name: 'verpokemons')]
    public function verPokemons(EntityManagerInterface $gestorEntidades): Response
    {
        $repoPokemons = $gestorEntidades->getRepository(Pokemons::class);
        $pokemons = $repoPokemons->findAll();


        return $this->render('pokemons/index.html.twig', [
            'controller_name' => 'PokemonsController',
            'Bichos' => $pokemons,
        ]);
    }
    //Consulta completa salida ARRAY JSON **ESTO LO PREGUNTA EN EL EXAMEN
    #[Route('/verPokemonsJSON', name: 'verpokemonsjson')]
    public function verpokemonsjson(PokemonsRepository $repoPokemons): Response
    {
        $pokemons = $repoPokemons->findAll();
        $datos = [];
        foreach ($pokemons as $pokemon) {
            $datos[] = [
                "idPokemon" => $pokemon->getId(),
                "nombre" => $pokemon->getNombre(),
                "altura" => $pokemon->getAltura(),
                "peso" => $pokemon->getPeso(),
                "sexo" => $pokemon->isSexo(),
                "categoria" => $pokemon->getIdCategoria()->getCategoria()
            ];
        }
        //puedes instalar en crhome el JSON Viewer para verlo bonito

        return new JsonResponse($datos);
    }
    //Consulta por parametro con salida array JSON (findBy)

    #[Route('/verPokemonsJSON/{sexo}', name: 'verpokemonsjsonparam')]
    public function verPokemonsJSONParam(PokemonsRepository $repoPokemons, bool $sexo): Response
    {
        //Consulta de pokemons por sexo
        //Y ordenarlo por altura de mayor a menor.
        $pokemons= $repoPokemons -> findBy(["sexo" => $sexo, ]);
        $datos = [];
        foreach ($pokemons as $pokemon) {
            $datos[] = [
                "idPokemon" => $pokemon->getId(),
                "nombre" => $pokemon->getNombre(),
                "altura" => $pokemon->getAltura(),
                "peso" => $pokemon->getPeso(),
                "sexo" => $pokemon->isSexo(),
                "categoria" => $pokemon->getIdCategoria()->getCategoria()
            ];
        }
        return $this->json($datos);
    }
    #[Route('/verPokemonsordenadosJSON/{sexo}', name: 'verpokemonsordenadosjsonparam')]
    public function verPokemonsOrdenadosJSONParam(PokemonsRepository $repoPokemons, bool $sexo): Response
    {
        //Y ordenarlo por altura de mayor a menor. Pregunta exeman
        $pokemons= $repoPokemons -> findBy(["sexo" => $sexo,],["altura"=>"DESC"]); 
        $datos = [];
        foreach ($pokemons as $pokemon) {
            $datos[] = [
                "idPokemon" => $pokemon->getId(),
                "nombre" => $pokemon->getNombre(),
                "altura" => $pokemon->getAltura(),
                "peso" => $pokemon->getPeso(),
                "sexo" => $pokemon->isSexo(),
                "categoria" => $pokemon->getIdCategoria()->getCategoria()
            ];
        }
        return $this->json($datos);
    }


}
