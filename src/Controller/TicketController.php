<?php

declare(strict_types=1);

namespace App\Controller;

use PHPUnit\Framework\Attributes\Ticket;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketController
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

        //Se inicializa la variabe $items que contendra los <li> de cada incidencia
        $items = '';

        foreach (self::TICKETS as $ticket) {
            $items .= "<li><a href='/tickets/{$ticket['id']}'>{$ticket['id']}</a>: {$ticket['title']}({$ticket['priority']})</li>";
        }
        $total = count(self::TICKETS);
        $title = 'Tickets';
        $html = <<<HTML
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>{$title}</title>
            </head>
            <body>
                <main>
                    <h1>{$title}</h1>
                    <p>Total: {$total} incidencias</p>
                    <ul>{$items}</ul>
                    <p><a href="/">Pagina principal</a></p>
                </main>
                
            </body>
            </html>

        HTML;

    
        return new Response($html, Response::HTTP_OK);
    }
    //Ruta dinamica para mostrar un ticket especifico por su ID.
    #[Route('/tickets/{id}', name:"app_ticket_show", methods: ['GET'])]
    //El metodo que devuelve un ticket en particular por convencion REST es show()
    public function show(string $id){

        //se inicializa la variable $ticket como null, qie contendra el ticket encontrado
        $ticket = null;

        //se recorre el array de tickets para buscar el ticket con el id proporcionado
        foreach (self::TICKETS as $candidate){
            if ($candidate['id'] === $id){
                $ticket = $candidate;
                break;
            }

        }

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
                    <p><a href="/">Pagina principal</a></p>
                    <p><a href="/tickets">Pagina Tickets</a></p>
                </main>
                
            </body>
            </html>

        HTML;
        return new Response($html, Response::HTTP_OK);
    }
}
