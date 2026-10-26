<?php
/*Crear la clase Ticket con las propiedades que ya veniamos usando i añadir un constructor */
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use InvalidArgumentException;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use PhpParser\Node\Scalar\String_;

/*
* Entity Doctrine de una incidencia de IssueFlow.
*
* Sigue siendo un objeto PHP con reglas de dominio. Los atributos #[ORM\ ... ]
* añaden el mapping necesario para que Doctrine sepa cómo persistirlo.
*/
#[ORM\Entity]
#[ORM\Table(name: 'tickets')]
final class Ticket{
    /**
     * Identificador técnico de base de datos.
     *
     * Empieza en null porque una Entity recién creada todavía no ha sido
     * insertada. Doctrine/la base asignarán el valor al persistirla.
     */

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:Types::BIGINT,options: ['unsigned' =>true])]
    private ?int $id = null;
    public function __construct(
        #[ORM\Column(length: 8, unique: true)]
        private readonly string $code,

        #[ORM\Column(length:180, unique: false)]
        private string $title,

        #[ORM\Column(length: 20,enumType: TicketPriority::class)]
        private TicketPriority $priority,

        #[ORM\Column(length: 20,enumType: TicketStatus::class)]
        private TicketStatus $status =  TicketStatus::Open

    ){
        /* Verificamos la forma del id comparando con una regex(expression regular)*/
        if (preg_match('/^INC-\d{4}$/', $this->code ) !== 1){
            throw new InvalidArgumentException('El formato del codigo del ticket no es valido');
        }
        
        /*Hacemos un trim (eliminar espacios antes i despues) de title */
        $normalizedTitle = trim($title);

        //Verificamos que la cadena de texto no este vacia
        if ($normalizedTitle === ''){
            throw new InvalidArgumentException();
        }

        $this->title = $normalizedTitle;
    }
    

    /* Crear los getters, para cada una de las propiedades*/
    public function getId(): ?int {
        return $this->id;
    }
    public function getCode() : string {
        return $this ->code;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getPriority(): TicketPriority {
        return $this->priority;
    }

    public function getStatus(): TicketStatus {
        return $this->status;
    }
    
    /*Crear un metodo isUrgent() que invoca a traves
    del atrributo priority al metodo isUrgent() de TicketPriority ek 
    cual retorne true si la prioridad es 'urgent', o false en el caso contrario
    o flase en caso contrario*/
    public function isUrgent():bool {
        return $this->priority->isUrgent();
    }

    public function isOpen():bool {
        return $this->status->isOpen();
    }
    
}
    
?>