<?php
declare (strict_types=1);

namespace App\Tests\Service;

use App\Model\Ticket;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use App\Service\InMemoryTicketCatalog;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

use function PHPUnit\Framework\assertInstanceOf;

final class InMemoryTicketCatalogTest extends TestCase
{
    
    #[Test]
    public function it_read_all():void
    {
        $catalog = new InMemoryTicketCatalog();
        $reded = $catalog->all();
        self::assertCount(3,$reded);
    }

     
    #[Test]
    public function it_find_an_existing_ticket():void
    {
        $catalog = new InMemoryTicketCatalog();
        $ticket = $catalog->find('INC-1001');
        self::assertInstanceOf(Ticket::class,$ticket);
        self::assertSame('INC-1001', $ticket->getId());
        

    }

}