<?php

declare(strict_types=1);

namespace App\Controller;

use App\Contract\TicketCatalogInterface;
use App\Contract\TicketSlaCalculatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//Mi clase TicketController hereda de AbstractController de Symfony.


final class TicketController extends AbstractController
{   
    //Inyeccion de dependencias
    public function __construct(
        private readonly TicketCatalogInterface $ticketCatalog,
        private readonly TicketSlaCalculatorInterface $ticketSlaCalculator,
        private readonly LoggerInterface $logger
    ){}

    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    // El metodo que devuelve la lista de tickets por convencion REST es index()
    public function index(): Response{
         return $this->render('ticket/index.html.twig',[
            'title' => 'Incidencias',
            'tickets' => $this ->ticketCatalog->all()
         ]);
    }

    //Ruta dinamica para mostrar un ticket especifico por su ID.
    #[Route('/tickets/{id}', name:"app_ticket_show", methods: ['GET'])]
    //El metodo que devuelve un ticket en particular por convencion REST es show()
    //El parametro $id identifica la ruta de ticket particular
    public function show(string $id){
        
        $ticket = $this -> ticketCatalog->find($id);

        if ($ticket === null){
            /*Usamos logger para conservar en el log informacion sobre este error */
            $this->logger->warning("Se solicito una incidencia inexistente.", [
                'ticket_id' => $id,
                'route' => 'app_ticket_show'
            ]);
            /*Lanzamos el error, no lo manejamos aqui, dejamos que symfony
            lo capture y lo transforme en una pagina 404 */
            throw $this->createNotFoundException(
                "No existe la incidencia " . $id
            );
        }
        /* So llego a esta linea es porque no se lanzo el error,
        por lo tanto el $ticket no es null*/

        /*Envio a la plantilla correspondiente los datos del ticket 
        encontrado que es: $ticket */
        return $this->render('ticket/show.html.twig',[
            'ticket' => $ticket,
            'responseTargetHours' => $this -> ticketSlaCalculator->getResponseTargetHours($ticket)
        ]);
    }
}
