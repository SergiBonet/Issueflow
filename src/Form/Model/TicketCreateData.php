<?php
declare (strict_types=1);

namespace App\Form\Model;

use App\Entity\Ticket;
use App\Entity\Category;
use App\Entity\User;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Datos de entrada para crear una incidencia desde un formulario.
 *
 * No es una Entity y Doctrine no la persiste. Su única responsabilidad es
 * recibir los datos que Symfony Form transforma desde la Request.
 *
 * Usamos propiedades públicas deliberadamente: este objeto es una estructura
 * simple de entrada, no nuestro modelo de dominio.
 */
#[UniqueEntity(
    fields: ['code'],
    entityClass: Ticket::class,
    message: 'Ya Existe una incidencia con este código',
    errorPath: 'code',
)]
final class TicketCreateData
{
    /**
    * NotBlank verifica que haya un valor.
    * Regex valida que el code cumpla con un patrón establecido
    */
    #[Assert\NotBlank(
        message: 'El codigo es obligatorio',
        normalizer: 'trim'
    )]
    #[Assert\Regex(
        pattern: '/^INC-\d{4}$/',
        message: 'El codigo debe tener el formato INC-0000',
        normalizer: 'trim'
    )]
    
    public string $code = '';

    #[Assert\NotBlank(
    message: 'El titulo es obligatorio',
    normalizer: 'trim'
    )]
    #[Assert\Length(
    max: 180,
    maxMessage:'El titulo no puede superar los 180 caracteres',
    normalizer: 'trim'
    )]
    public string $title = '';

    public TicketPriority $priority = TicketPriority::Normal;
    public TicketStatus $status = TicketStatus::Open;
    public ?Category $category = null;
    public ?User $assigne = null;

    public function mapToTicket(): Ticket
    {
        $ticket = new Ticket(
        code: $this->code,
        title: $this->title,
        priority: $this->priority,
        status: $this->status,
        );
        $ticket->setCategory($this->category);
        $ticket->assignTo($this->assigne);

        return $ticket;
    }
}
?>