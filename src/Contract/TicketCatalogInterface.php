<?php

declare(strict_types=1);

namespace App\Contract;

use App\Entity\Ticket;
use App\Form\Model\TicketSearchCriteria;
use Doctrine\ORM\Tools\Pagination\WindowPage;

/*
Contrato que necesita IssueFlow de cualquier catálogo de tickets.
la interfaz describe que operaciones deben existir, pero no como
se realizan.
*/

interface TicketCatalogInterface
{
    //Metodo que devuelve todas las incidencias
    public function all(): array;

    //Metodo que devuelve una incidencia dado su codigo, si no encuentra ninguna devuelve null
    public function findByCode(string $code): ?Ticket;

    //Metodo que devuelve un listado de incidencias dado unos criterios de busqueda
    public function search(TicketSearchCriteria $criteria, int $page, int $pageSize): WindowPage;
}
