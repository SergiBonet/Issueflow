<?php
declare (strict_types=1);

namespace App\Tests\model;

use App\Model\Ticket;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use InvalidArgumentException;

final class TicketTest extends TestCase
{
    /*
    Puedo realizar varios test unitarios para la clase Ticket.
    En general un test unitario tiene la siguiente estructura:
    - Arrange: Que necesito preparar? -Contexto del test
    - Act: Que comportamiento ejecuto?
    - Assert: Que resultado debe cumplirse?    
    */
    #[Test]
    public function it_normalizes_the_title_when_the_ticket_is_created(): void
    {
        $ticket = new Ticket(
            id: 'INC-1001',
            title: '            No puede iniciar sesion         ',
            priority: TicketPriority::Urgent,
            status:TicketStatus::Open
        );

        /*
        Assert: verificamos el comportamiento observable esperado 
        1r argumento: que resultado espero yo obtener
        */
        self::assertSame('No puede iniciar sesion',$ticket->getTitle());
    }

    #[Test]
    public function it_rejects_an_invalid_identifier(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Ticket(
            id: 'Ticket0001',
            title: 'Incidencia válida',
            priority: TicketPriority::Low,
            status:TicketStatus::InProgres
        );
    }

    #[Test]
    public function it_rejects_an_empty_title(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Ticket(
            id: 'INC-0001',
            title: '',
            priority: TicketPriority::Low,
            status:TicketStatus::InProgres
        );
    
    }

    #[Test]
     public function it_reports_when_a_ticket_is_urgent(): void
     {
        $ticket = new Ticket(
            id: 'INC-1003',
            title: 'Servidor no disponible',
            priority: TicketPriority::Urgent,
            status: TicketStatus::Open
        );
        self::assertTrue($ticket->isUrgent());
     }

   
}

/*TDD: Test Driven development
Para una implementacio:
1ro: Escribo los test: me van a servir como un listado 
de las funcionalidades de lo que quiero implementar. Me dicen 
como debe funcionar mi implementacion para los distintos casos posibles.
Este es el momento de imaginarme todos los escenarios posibles.
En principio todos los test van a resultar en Fallas: estan todos en rojo.
2do: Escribo el codigo minimo (calidad) que haga pasar los test: los test van a estar en verde.
3ro: Refactorizar -> mejoras del codigo 
4to: Todo en verde y el codigo optimizado


Historia de usuario:
Como usuario, quiero ver la lista de tickets.
TDD:
1. Prueba (falla):  
2. “El servicio debe devolver una lista de tickets.”
3. Código mínimo:  
4. Implementas el servicio para devolver una lista vacía o mock.
5. Prueba pasa:  
6. La prueba ya no falla.
7. Refactor:  
8. Mejoras el servicio, agregas validaciones, etc.
9. Nueva prueba:  
10. “Debe devolver tickets ordenados por fecha.”
11. Repite el ciclo.
*/