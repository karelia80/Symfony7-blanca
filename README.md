# Symfony7-blanca


php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate


drop -> Eliminas la bbdd
create -> Creas la bbdd
migrate -> Introduces tablas



## Endpoints (direcciones)
localhost:8000/categorias/insertar
localhost:8000/categorias/insertar/Semilla
localhost:8000/categorias/insertar-array
localhost:8000/pokemons/insertar/1/Bulbasaur/70/6.9/1
localhost:8000/pokemons/insertar/2/Ivysaur/100/13.0/1
localhost:8000/pokemons/verPokemons
localhost:8000/pokemons/verPokemonsJSON
localhost:8000/pokemons/verPokemonsJSON/1
localhost:8000/pokemons/verPokemonsordenadosJSON/{sexo}