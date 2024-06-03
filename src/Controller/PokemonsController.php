<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Entity\Pokemons;
use App\Repository\PokemonsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $pokemons = $repoPokemons->findBy(["sexo" => $sexo,]);
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
        $pokemons = $repoPokemons->findBy(["sexo" => $sexo,], ["altura" => "DESC"]);
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

    //Actualizar con parametros pag 41 manual
    #[Route('/actualizar/{id}/{altura}/{peso}', name: 'actualizarparams')]
    public function actualizarParams(ManagerRegistry $doctrine, int $id, int $altura, float $peso): Response
    {
        $gestorEntidades = $doctrine->getManager();
        //Sacamos el pokemon que vamos a actualizar
        $repoPokemons = $gestorEntidades->getRepository(Pokemons::class);
        $pokemon =  $repoPokemons->find($id);

        if (!$pokemon) {
            throw $this->createNotFoundException("No se ha encontrado este Pokemon");
        }
        $pokemon->setAltura($altura);
        $pokemon->setPeso($peso);
        $gestorEntidades->flush();

        //Hacer redireccion (EXAMEN) Se redirecciona al nombre de la ruta!!! sale en el php bin/console debug:router

        return $this->redirectToRoute("app_pokemons_verpokemons");
    }
    //DELETE, eliminar con parametros (id)

    #[Route('/eliminar/{id}', name: 'eliminar')]
    public function eliminar(EntityManagerInterface $gestorEntidades, int $id): Response
    {

        //sacamos el pokemon que vamos a eliminar
        $repoPokemons = $gestorEntidades->getRepository(Pokemons::class);
        $pokemon =  $repoPokemons->find($id);

        //y ahora Borramos y actualizamos
        $gestorEntidades->remove($pokemon);
        $gestorEntidades->flush();

        return new Response("Pokemon Eliminado con ID: " . $id);
    }
    //FORMULARIOS
    //dos inyescciones: la solicitud(request)y el doctrine

    #[Route('/formulario', name: 'formulario')]
    public function formulario(Request $request, ManagerRegistry $doctrine): Response
    {
        //1. Creamos el objeto a guardar vacio

        $pokemon = new Pokemons();

        //2. Creamos el objeto formulario

        $formulario = $this->createFormBuilder($pokemon)
            ->add("nombre", TextType::class, [
                "attr" => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add("altura", IntegerType::class, [
                "attr" => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add(
                "peso",
                NumberType::class,
                [
                    "attr" => ['class' => 'form-control', 'step' => '0.01'],
                    'html5' => true
                ]
            )
            ->add("sexo", ChoiceType::class, [
                "choices" => ['macho' => false, "Hembra" => true],
                "attr" => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
            ])

            //Vamos a añadir el capo FK Clave foranea
            ->add("idCategoria", EntityType::class, [
                "class" => Categorias::class, //Entidad
                //este choice es dentro de la entidad de pokemons se corresponde el nombre en la BBDD
                "choice_label"  =>  "categoria", //aqui en minuscula
                "placeholder"=> "Selecciona Categoria",
                "attr" => ['class' => 'form-select'],

            ])

            ->add("guardar", SubmitType::class,["attr" => ['class' => 'btn btn-dark'],
             "label" => "Guardar Pokemon"])


            ->getForm();


        //3. Tratar el formulario. ir a la doc symfony a procesador de formularios https://symfony.com/doc/current/forms.html#processing-forms

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $gestorEntidades = $doctrine->getManager();
            $gestorEntidades->persist($pokemon);
            $gestorEntidades->flush();

            //Redicionamos
            return $this->redirectToRoute("app_pokemons_verpokemons");
        }



        //4. Pintar el formulario.
        return $this->render('pokemons/formulario.html.twig', [
            'controller_name' => 'PokemonsController',
            "formulario" => $formulario,
        ]);
    }
}
