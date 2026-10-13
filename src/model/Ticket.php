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
        private string $priority
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
    
    /*Crear un metodo isUrgent() que retorne true si la prioridad es 'urgent',
    o flase en caso contrario*/
    public function isUrgent(){
        return $this->priority === 'urgent';
    }
}


?>