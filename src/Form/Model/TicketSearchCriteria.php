<?php
declare(strict_types=1);

namespace App\Form\Model;

use App\Entity\Category;
use App\Model\TicketPriority;
use App\Model\TicketStatus;

/**
 * Criterios de busqueda del listado de incidencias.
 * Este objeto representa el estado del formulario
 * 
 */
final class TicketSearchCriteria
{
   //Texto libre para buscar por codigo o titulo
   public ?string $query = '';
   
   //Filtramos por prioridad
   public ?TicketPriority $priority = null;

   //Filtramos tambien por estado
   public ?TicketStatus $status = null;

   //Filtramos tambien por categoria
   public ?Category $category = null;
}

?>