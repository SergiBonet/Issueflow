<?php

declare(strict_types=1);

namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;

/**
 * Usuario minimo para asignar incidencias(tecnico)
 * Aun no implemetamos autentificacion
 */
#[ORM\Entity]
#[ORM\Table(name: 'categories')]
final class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'category')]
    private Collection $tickets;

    public function __construct(
        #[ORM\Column(length: 120, unique:true)]
        private readonly string $name,
    ) {

        //Normalizamos $name
        $normalizedName = trim($name);

        // Validamos que el nombre de usuario no está vacío
        if ($normalizedName === '') {
        throw new InvalidArgumentException('El nombre de usuario no puede estar vacio');
        }
        $this->name = $normalizedName;
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int{
        return $this->id;
    }
    public function getName(): string{
        return $this->name;
    }
    
    public function getTickets(): Collection{
        
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket) :void{
        if ($this->tickets->contains($ticket)){
            return;
        }
        $this->tickets->add($ticket);
        $ticket->setCategorie($this);

    }

    public function removeTicket(Ticket $ticket) : void {
        if(!$this->tickets->removeElement($ticket)){
            return;
        }
        if ($ticket->getCategory()===$this){
            $ticket->setCategorie(null);
        }
    }
}
