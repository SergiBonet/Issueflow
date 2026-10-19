<?php
declare (strict_types=1);

namespace App\Contract;

Use App\Model\Ticket;

/*
Contrato que necesita IssueFlow de cualquier catálogo de tickets.
la interfaz describe que operaciones deben existir, pero no como
se realizan.
*/
interface TicketCatalogInterface{
    //Metodo que devuelve todas las incidencias
    public function all(): array;

    //Metodo que devuelve una incidencia dado su id, si no encuentra ninguna devuelve null
    public function find(string $id): ?Ticket;

    
}
?>