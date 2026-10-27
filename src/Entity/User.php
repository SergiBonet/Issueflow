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
#[ORM\Table(name: 'users')]
final class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column(length: 120)]
        private readonly string $name,

        #[ORM\Column(length: 120, unique: true)]
        private string $email,

        #[ORM\Column(type: Types::DATE_IMMUTABLE)]
        private DateTimeImmutable $createdAt = new DateTimeImmutable()
    ) {
        //Normalizamos $name y $email
        $normalizedName = trim($name);
        $normalizedEmail = strtolower(trim($email));

        if ($normalizedEmail === '') {
            throw new InvalidArgumentException('El nombre del usuario no puede estar vacio');
        }

        /*Existe una forma de validar que el email tenga una estructura valida */
        if (filter_var($normalizedEmail, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('El email del usuario no es un formato correcto');
        }

        $this->name =$normalizedName;
        $this->email = $normalizedEmail;
    }

    public function getId(): ?int{
        return $this->id;
    }
    public function getName(): string{
        return $this->name;
    }
    public function getEmail(): string{
        return $this->email;
    }

    
}
