<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

//Mi clase TicketController hereda de AbstractController de Symfony.
final class TicketController extends AbstractController
{
    /*En este caso los tickets se definen de forma estatica.
    En un caso real se obtendria de una base de datos*/
    /*TICKETS es un array donde cada elemento es un ticket en particular
    cada ticket es un array asociativo, que contiene los datos o propiedades de este*/
    //Esto es una constante de clase 
    private const TICKETS = [
        ['id' => 'INC-1001', 'title' => 'No puedo iniciar sesión', 'priority' => 'urgent'],
        ['id' => 'INC-1002', 'title' => 'Error en la factura', 'priority' => 'high'],
        ['id' => 'INC-1003', 'title' => 'Actualizar datos de contacto', 'priority' => 'normal'],
    ];
    
    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    // El metodo que devuelve la lista de tickets por convencion REST es index()
    public function index(): Response{
         return $this->render('ticket/index.html.twig',[
            'title' => 'Incidencias',
            'tickets' => self::TICKETS            
         ]);
    }
    //Ruta dinamica para mostrar un ticket especifico por su ID.
    #[Route('/tickets/{id}', name:"app_ticket_show", methods: ['GET'])]
    //El metodo que devuelve un ticket en particular por convencion REST es show()
    //El parametro $id identifica la ruta de ticket particular
    public function show(string $id, Request $request){

        //se inicializa la variable $ticket como null, qie contendra el ticket encontrado
        $ticket = null;


        //se recorre el array de tickets para buscar el ticket con el id proporcionado
        foreach (self::TICKETS as $candidate){
            if ($candidate['id'] === $id){
                $ticket = $candidate;
                break;
            }

        }
        //En este punto del codigo, si $ticket sigue siendo null, significa que no se encontro ningun ticket con el id proporcionado.
        //Si es null voy a lanzar un error 404.
        if ($ticket===null){
            //throw $this->createNotFoundException('La incidencia no existe');
            $html = <<<HTML
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Ticket no existe</title>
                </head>
                <body>
                    <h1>El ticket solicitado no existe</h1>
                    <h2>***********Error 404***********</h2>
                    <a href="/tickets">Volver a tickets</a>
                </body>
                </html>

            HTML;
            return new Response($html, Response::HTTP_NOT_FOUND);
        }
        //Voy a checkear si tengo parametros en la peticion/request (query)
        //esto recupera el valor de view si existe en la URL:
        //http://localhost8000/tickets/INC-1001?view=compact
        //Si no existe le asigna a $view el valor por defecto 
        
        $view = $request->query->get('view','full');

        if($view==='compact'){
            $html = <<<HTML
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Ticket {$id}</title>
                </head>
                <body>
                    <main>
                        <h1>Ticket {$id}</h1>
                        <p>Title: Compacta</p>
                        
                    </main>
                    
                </body>
                </html>

            HTML;
        }else{
            $html = <<<HTML
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Ticket {$id}</title>
                </head>
                <body>
                    <main>
                        <h1>Ticket {$id}</h1>
                        <p>Title: {$ticket['title']}</p>
                        <p>Priority: {$ticket['priority']}</p>
                    </main>
                    
                </body>
                </html>
    
            HTML;
        }
        return new Response($html, Response::HTTP_OK);
    }
}
