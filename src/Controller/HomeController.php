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
    el cual genera la respuesta para el cliente, que sera un objeto de la clase Response.*/

    #[Route('/',name:'app_home',methods: ['GET'])]
    public function index():Response {
        $projectName = 'IssueFlow';
        $message = 'Symfony ha recibido la peticion y ha devuelto un Response';
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
                <main>
                    <h1>{$projectName}</h1>
                    <p>{$message}</p>
                    <p><a href="/tickets">Ver Incidencias</a></p>
                    <p><a href="/health">Comprobar estado</a></p>
                </main>
                
            </body>
            </html>

        HTML;

        //Retornamos la respuesta
        return new Response($html, Response::HTTP_OK);
    }
    
    #[Route('/health',name:'app_health',methods: ['GET'])]
    public function health():Response{
        //Especifico que el contenido es text/plain i no un documento html.
        return new Response('IssueFlow OK', Response::HTTP_OK, ['Content-Type' => 'text/plain']);
    }

    
}
