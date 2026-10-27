<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

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

    public function __construct(
        #[ORM\Column(length: 120, unique:true)]
        private readonly string $name,
    ) {
        //Normalizamos $name y $email
        $normalizedName = trim($name);

        $this->name =$normalizedName;
    }

    public function getId(): ?int{
        return $this->id;
    }
    public function getName(): string{
        return $this->name;
    }
    
}
