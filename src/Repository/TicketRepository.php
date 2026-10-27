<?php
declare (strict_types=1);

namespace App\Repository;

use App\Contract\TicketCatalogInterface;
use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/*
*Repository Doctrine de Ticket
Implementa TicketCatalogInterface

*/
#[AsAlias(TicketCatalogInterface::class)]
final class TicketRepository extends ServiceEntityRepository implements TicketCatalogInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        return parent::__construct($registry, Ticket::class);
    }

    //Metodo que devuelve todas las incidencias
    public function all(): array
    {
       return $this->findBy([],['id' => 'ASC']);
    }

    //Metodo que devuelve una incidencia dado su codigo, si no encuentra ninguna devuelve null
    public function findByCode(string $code): ?Ticket
    {
        return $this->findOneBy(['code'=>$code]);
    }
}
?>