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
    public function show(string $id){
        $ticket = array_find(
            self :: TICKETS,
            fn(array $ticket): bool => $ticket['id'] === $id
        );

        if ($ticket === null){
            throw $this->createNotFoundException(
                "No existe la incidencia " . $id
            );
        }
        /* So llego a esta linea es porque no se lanzo el error,
        por lo tanto el $ticket no es null*/

        /*Envio a la plantilla correspondiente los datos del ticket 
        encontrado que es: $ticket */
        return $this->render('ticket/show.html.twig',[
            'ticket' => $ticket
        ]);
    }
}
