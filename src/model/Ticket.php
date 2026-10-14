<?php
/*Crear la clase Ticket con las propiedades que ya veniamos usando i añadir un constructor */
declare(strict_types=1);

namespace App\Model;

/*
final class Ticket{
    private string $id;
    private string $title;
    private string $priority;

    public function __construct(string $id, string $title, string $priority){
        $this->id = $id;
        $this->title = $title;
        $this->priority = $priority;

    }
}
*/
/*
     * Constructor Property Promotion (PHP moderno).
     *
     * Al escribir "private string $id" dentro del constructor, PHP hace dos
     * cosas: declara la propiedad y asigna automáticamente el argumento recibido.
     * Esto evita repetir la declaración y la asignación manual de cada propiedad.
*/
final class Ticket{
    
    public function __construct(
        private string $id,
        private string $title,
        private string $priority,
        private string $status
    ){}
    

    /* Crear los getters, para cada una de las propiedades*/
    public function getId(): string {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getPriority(): string {
        return $this->priority;
    }

    public function getStatus(): string {
        return $this->status;
    }
    
    /*Crear un metodo isUrgent() que retorne true si la prioridad es 'urgent',
    o flase en caso contrario*/
    public function isUrgent():bool {
        return $this->priority === 'urgent';
    }

    public function isOpen():bool {
        return $this->status === 'open';
    }

    /*Este metodo crea  temporalmente los ticket en memoria.(Antes usabamos
    una constante de clase) Mas adelante este trabajo lo hara una capa de 
    persistencia/Repository conectado a Doctrine y MySQL 
    Un metodo estatico puede ser llamdo directamente desde la clase sin
    haber instanciado un objeto: Ticket::getAllTickets();
    
    */
    public static function getAllTickets(): array{
        return [
                new Ticket(
                    id: 'INC-1001',
                    title: 'No puedo iniciar sesión',
                    priority: 'urgent',
                    status:'open'
                ),
                new Ticket(
                    id: 'INC-1002',
                    title: 'Error en la factura',
                    priority: 'high',
                    status: 'in_progres'
                ),
                new Ticket(
                    id: 'INC-1003',
                    title: 'Actualizar datos de contacto',
                    priority: 'normal',
                    status: 'closed'
                ),
            ];
    }
    
}
    
?>