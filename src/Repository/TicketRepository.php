<?php
declare (strict_types=1);

namespace App\Repository;

use App\Contract\TicketCatalogInterface;
use App\Entity\Ticket;
use App\Form\Model\TicketSearchCriteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\OffsetPaginator;
use Doctrine\ORM\Tools\Pagination\Window;
use Doctrine\ORM\Tools\Pagination\WindowPage;
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


    /**
     * Construye una consulta con los filtros y devuelve una pagina de resultados
     *
     */
    public function search(TicketSearchCriteria $criteria,int $page, int $pagSize): WindowPage
    {
        /**
         * Construimos una query que pide todos los tickets, agrega
         * la informacion de category i assigne y ordena por id de manera descendiente
         */
        $queryBuilder = $this->createQueryBuilder('ticket')
            ->leftJoin('ticket.category','category')
            ->addSelect('category')
            ->leftJoin('ticket.assigne','assigne')
            ->addSelect('assigne')
            ->orderBy('ticket.id','DESC');
        
        //Normalizamos el primer criterio de busqueda (titulo o codigo)
        $term = $criteria->query ? trim($criteria->query): '';

        //Si hay criterio de busqueda por titulo o codigo lo agregamos a la query
        if(($term)!== ''){
            $queryBuilder 
                //andWhere agrega un filtro o condicion a la query 
                //LOWER hace que se ignore mayusculas i minusculas al comparar
                //LIKE compara las cadenas de texto
                ->andWhere(
                    'LOWER(ticket.code) LIKE :term OR LOWER(ticket.title) LIKE :term'
                )
                //Evita concatenar directamente la entrada del usuario
                //Evita inyecciones SQL
                ->setParameter('term','%'.strtolower($term).'%');
        }

        //Aplicamos filtro por prioridad si no es null
        if($criteria->priority !== null){
            $queryBuilder
                ->andWhere('ticket.priority = :priority')
                ->setParameter('priority', $criteria->priority->value);
        }

        //Aplicamos filtro por status si no es null
        if ($criteria->status !==null) {
            $queryBuilder
                ->andWhere('ticket.status = :status')
                ->setParameter('status', $criteria->status->value);
        }

        //Aplicamos filtro por categoria si no es null
        if ($criteria->category !==null) {
            $queryBuilder
                ->andWhere('ticket.category = :category')
                ->setParameter('category', $criteria->category);
        }

        //La pagina nunca puede ser menor que 1
        
        //Del listado de resultados posibles solo trae los correspondientes a la pagina definida por $page, que serian $pagSize resultados
        return (new OffsetPaginator(fetchJoinCollection: false))->paginate(
            $queryBuilder,
            Window::fromPageNumberAndSize($page,$pagSize)
        );
    }
}
?>