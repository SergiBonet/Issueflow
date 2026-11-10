<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Override;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario minimo para asignar incidencias(tecnico)
 * Aun no implemetamos autentificacion
 */
#[ORM\Entity]
#[ORM\Table(name: 'users')]
final class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(length:255, nullable:true)]
    private ?string $password = null;

    #[ORM\Column(type: Types::JSON,nullable:true)]
    private ?array $roles = [];

    public function __construct(
        #[ORM\Column(length: 120)]
        private string $name,

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
    public function getCreatedAt(): DateTimeImmutable{
        return $this->createdAt;
    }

    //Implementaciones de los metodos de las interfaces
  
    //Metodo que devuelve el identificador publico
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    //Necesito un metodo que devuelva el listado de roles en un usuario
    public function getRoles(): array
    {
       $roles = $this->roles ?? [];
       //Garantizamos que siempre hay un rol
       $roles[] = 'ROLE_USER';
       return array_values(array_unique($roles));
    }

    
    public function getPassword(): ?string
    {
        return $this->password;
    }
    
    public function setPassword(string $hashedPassword): void
    {
        $this->password = $hashedPassword;
    } 

    public function setRoles(array $roles): void
    {
        $this->roles = array_values(array_unique($roles));
    }
}