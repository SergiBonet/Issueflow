<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketController
{
    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    // El metodo que devuelve la lista de tickets por convencion REST es index()
    public function index(): Response{
        /*En este caso los tickets se definen de forma estatica.
        En un caso real se obtendria de una base de datos*/
        /*$tickets es un array donde cada elemento es un ticket en particular
        cada ticket es un array asociativo, que contiene los datos o propiedades de este*/
        $tickets = [
            ['id' => 'INC-1001', 'title' => 'No puedo iniciar sesión', 'priority' => 'urgent'],
            ['id' => 'INC-1002', 'title' => 'Error en la factura', 'priority' => 'high'],
            ['id' => 'INC-1003', 'title' => 'Actualizar datos de contacto', 'priority' => 'normal'],
        ];

        //Se inicializa la variabe $items que contendra los <li> de cada incidencia
        $items = '';

        foreach ($tickets as $ticket) {
            $items .= "<li>{$ticket['id']}: {$ticket['title']}({$ticket['priority']})</li>";
        }
        $total = count($tickets);
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

        // TODO 3: devolver una Response HTTP 200.
        return new Response($html, Response::HTTP_OK);
    }
}
