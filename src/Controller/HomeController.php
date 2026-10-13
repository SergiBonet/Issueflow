<?php

declare(strict_types =1);

namespace App\Controller;

//Clase de symfony para construir las respuestas para el cliente
use Symfony\Component\HttpFoundation\Response;
//Clase de symfony para definir las rutas
use Symfony\Component\Routing\Attribute\Route;

/*Clase de symfony para asociar un metodo del controlador con una plantilla Twig,
de manera que el metodo devuelva un array con los datos a renderizar en la pantalla
Lo necesitamos para poder usar la anotacion #[Template('home/index.html.twig')]
en el metodo del controlador, y que twig renderice la plantilla con los datos
devueltos por el metodo*/
//use Symfony\Bridge\Twig\Attribute\Template;

/* Para poder usar el método render() de la clase AbstractController,
   necesitamos primero importar la clase AbstractController, 
   y luego extender nuestra clase HomeController de ella.
*/
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//Clase controlador HomeController
final class HomeController extends AbstractController{

    /*Definiimos una ruta para este controlador
    La ruta sera la de home, '/' -> 1er argumento
    Tendra un nombre interno: 'app_home' -> 2do argumento
    solo para metodos GET ->3er argumento 
    Luego de la ruta definimos el method correspondiente a ella,
    el cual genera la respuesta para el cliente, que sera un objeto de la clase Response.*/

    #[Route('/',name:'app_home',methods: ['GET'])]

    /* Comentado el #[Template('home/index.html.twig')] porque no lo necesitamos, 
    ya que estamos usando el método render() de la clase AbstractController */
    //#[Template('home/index.html.twig')]
    public function index(): Response{//En caso de usaar #[Template('...')], el tipo de retorno seria array.

        /*Retorno un objeto Response a traves del metodo Render,
        el primer argumento de render corresponde  a la plantilla i
        el segundo al array de datos*/
        return $this->render('home/index.html.twig',
            [
            'projectName' => 'IssueFlow',
            'message' => 'Symfony 8.1 ha resuelto la ruta y twig ha construido la vista'
            ]);
    }
    
    #[Route('/health',name:'app_health',methods: ['GET'])]
    public function health():Response{
        //Especifico que el contenido es text/plain i no un documento html.
        return new Response('IssueFlow OK', Response::HTTP_OK, ['Content-Type' => 'text/plain']);
    }

    
}
