<?php

declare(strict_types =1);

namespace App\Controller;

//Clase de symfony para construir las respuestas para el cliente
use Symfony\Component\HttpFoundation\Response;
//Clase de symfony para definir las rutas
use Symfony\Component\Routing\Attribute\Route;
//Clase de symfony para asociar un metodo del controlador con una plantilla Twig
use Symfony\Bridge\Twig\Attribute\Template;
//Clase controlador HomeController
final class HomeController{

    /*Definiimos una ruta para este controlador
    La ruta sera la de home, '/' -> 1er argumento
    Tendra un nombre interno: 'app_home' -> 2do argumento
    solo para metodos GET ->3er argumento 
    Luego de la ruta definimos el method correspondiente a ella,
    el cual genera la respuesta para el cliente, que sera un objeto de la clase Response.*/

    #[Route('/',name:'app_home',methods: ['GET'])]
    #[Template('home/index.html.twig')]
    public function index(): array{
        return[
            'projectName' => 'IssueFlow',
            'message' => 'Symfony 8.1 ha resuelto la ruta y twig ha construido la vista'
        ];
    }
    
    #[Route('/health',name:'app_health',methods: ['GET'])]
    public function health():Response{
        //Especifico que el contenido es text/plain i no un documento html.
        return new Response('IssueFlow OK', Response::HTTP_OK, ['Content-Type' => 'text/plain']);
    }

    
}
