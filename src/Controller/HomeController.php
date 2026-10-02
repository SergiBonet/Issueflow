<?php

declare(strict_types =1);
namespace App\Controller;
//Clase de symfony para construir las respuestas para el cliente
use Symfony\Component\HttpFoundation\Response;

//Clase de symfony para definir las rutas
use Symfony\Component\Routing\Attribute\Route;

//Clase controlador HomeController
final class HomeController{

    /*Definiimos una ruta para este controlador
    La ruta sera la de home, '/' -> 1er argumento
    Tendra un nombre interno: 'app_home' -> 2do argumento
    solo para metodos GET ->3er argumento 
    Luego de la ruta definimos el method correspondiente a ella,
    el cual genera la respuesta para el cliente, que sera un objeto de la clase Response.

    */
    #[Route('/',name:'app_home',methods: ['GET'])]
    public function index():Response {
        $projectName = 'IssueFlow';
        //Creamos una variable que contiene el archivo HTML.
        $html = <<<HTML
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>{$projectName}</title>
            </head>
            <body>
                <h1>{$projectName}</h1>
            </body>
            </html>

        HTML;

        //Retornamos la respuesta
        return new Response($html, Response::HTTP_OK);

    }
    
}
