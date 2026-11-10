<?php

declare(strict_types=1);

namespace App\Contract;

use App\Entity\Ticket;

/*
Contrato que necesita IssueFlow de cualquier catálogo de tickets.
la interfaz describe que operaciones deben existir, pero no como
se realizan.
*/

interface TicketSlaCalculatorInterface
{
    public function getResponseTargetHours(Ticket $ticket): int;
}
