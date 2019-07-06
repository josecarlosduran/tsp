# Algoritmo TSP mediante BranchBound

Resolucion del problema del vendedor viajero (TSP) mediante algoritomo de Branch Bound

Este programa lo programo para un ejercicio propuesto por Eurona



### Pre-requisitos 📋


```
PHP 7.3
Composer
Git
```

### Instalación 🔧


Clona el proyecto en tu ordenador en local:
```

git clone https://github.com/josecarlosduran/tsp.git tsp
```

Accede a la carpeta tsp
```
cd tsp
```
Instala las dependencias
```
composer install
```


## Ejecutando las pruebas

Hay programados test unitarios para comprobar que este todo correcto, dentro de la carpeta del proyecto ejecutar lo siguiente:
```
 ./vendor/bin/simple-phpunit

```

## Ejecucion
```
bin/console app:generate-path 
```
## Descripcion 

El programa tomara una lista de clientes (ciudades) y sus coordenadas ubicadas en un fichero de texto clientes.txt y las mostrara en pantalla ordenadas de manera que la ruta sea la de la distancia mas corta.

En la raiz del proyecto ya hay incluido un fichero clientes.txt pero se puede cambiar por cualquier otro o incluso ejecutar desde otra carpeta. El programa buscara en el directorio actual de ejecucion dicho fichero clientes.txt

## Arquitectura 

Se ha programado usando el framework Symfony 3.4 intentando desacoplar el codigo lo maximo posible usando arquitectura hexagonal (aunque no se ha modificado el boilerplate y estructuras de carpetas de symfony).
Se han usado interfaces para desacoplar tanto la entrada de datos como la salida.

