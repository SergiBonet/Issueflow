<?php

declare(strict_types=1);

namespace App\Controller;

use App\Contract\TicketCatalogInterface;
use App\Contract\TicketSlaCalculatorInterface;
use App\Entity\Ticket;
use App\Form\Model\TicketCreateData;
use App\Form\TicketType;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
//Mi clase TicketController hereda de AbstractController de Symfony.


final class TicketController extends AbstractController
{   
    //Inyeccion de dependencias
    public function __construct(
        private readonly TicketCatalogInterface $ticketCatalog,
        private readonly TicketSlaCalculatorInterface $ticketSlaCalculator,
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $entityManager,
    ){}

    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    // El metodo que devuelve la lista de tickets por convencion REST es index()
    public function index(): Response{
         return $this->render('ticket/index.html.twig',[
            'title' => 'Incidencias',
            'tickets' => $this ->ticketCatalog->all()
         ]);
    }

    /**
     * GET: Muestra el formulario vacio
     * POST: Recibe el formulario cuando se envie con sus valores,
     * Estos se procesan y se persisten en la base de datos si son correctos
     * Los datos del formulario vienen en el objeto Request
     */
    #[Route('/tickets/new',name:'app_ticket_new', methods:['GET','POST'])]
    public function new(Request $request):Response{
        //Voy a crear un objeta TicketCreateData para recibir la info del formulario
        $data = new TicketCreateData();

        /*Creamos un formulario con el metodo createForm() heredado de abstractController
        1er parametro corresponde a la clase que define el formulario
        2ndo parametro corresponde al el objeto (DTO) que recibe la informacion del formulario
        */
        $form = $this-> createForm(TicketType::class,$data);
        /**
         * handleRequest() hace lo siguiente:
         *  Detectar el envio del formulario
         *  Extraer los datos correspondientes del request
         *  Transformar los valores al tipo esperado
         *  Assigna los datos al objeto TicketCreateData
         * 
         */
        $form->handleRequest($request);

        /*Checkeo si el estado del formulario fue enviado y ademas si el form es valido
            isValid() puede ejecutar las reglas de validacion definidas en el DTO TicketCreateData

        */

        if($form->isSubmitted() &&$form->isValid()){
            try{
                //Construimos la entidad ticket con los datos ya validados en el DTO
                $ticket = new Ticket(
                    code: $data->code,
                    title: $data->title,
                    priority: $data->priority,
                    status: $data->status
                );
                //Las relaciones som opcionales i se asignan mediante la API de Ticket
                $ticket->setCategorie($data->category);
                $ticket->assignTo($data->assigne);
            } catch(InvalidArgumentException $exception){
                /**
                 * Si hay un error lo agregamos al formulario, y volvemos a
                 * cargar la plantilla del formulario
                 */
                new FormError($exception->getMessage());
                return $this->render('ticket/new.html.twig',[
                    'form' => $form
                ]);
            }
            //Solo llegamos aqui si el ticket se construyo correctamente
            //Usamos el entityManager para persistir el ticket en la base de datos
            $this->entityManager->persist($ticket);
            $this->entityManager->flush();

            //Luego de guardar el ticket, redirigimos a la pagina de detalle de ticket
            return $this->redirectToRoute('app_ticket_show',[
                'code'=> $ticket->getCode()
            ]);
        }
        // Si el formulario no fue enviado o no es válido, es un GET, mostramos el formulario
        return $this->render('ticket/new.html.twig', [
            'form' => $form,
        ]);
    }


    //Ruta dinamica para mostrar un ticket especifico por su ID.
    #[Route('/tickets/{code}', name:"app_ticket_show", methods: ['GET'])]
    //El metodo que devuelve un ticket en particular por convencion REST es show()
    //El parametro $id identifica la ruta de ticket particular
    public function show(string $code):Response{
        
        $ticket = $this -> ticketCatalog->findByCode($code);

        if ($ticket === null){
            /*Usamos logger para conservar en el log informacion sobre este error */
            $this->logger->warning("Se solicito una incidencia inexistente.", [
                'ticket_code' => $code,
                'route' => 'app_ticket_show'
            ]);
            /*Lanzamos el error, no lo manejamos aqui, dejamos que symfony
            lo capture y lo transforme en una pagina 404 */
            throw $this->createNotFoundException(
                "No existe la incidencia " . $code
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
