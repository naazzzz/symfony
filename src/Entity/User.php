<?php

namespace App\Entity;

use AllowDynamicProperties;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[AllowDynamicProperties]
#[ORM\Entity]
#[ORM\Table(name: 'users')]
#[UniqueEntity("name")]
#[UniqueEntity("email")]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    #[Groups(['user'])]
    public int $id;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups(['user'])]
    public string $name;

    #[ORM\Column(type: 'string')]
    #[Groups(['user'])]
    #[Assert\Length(min: 7)]
    #[Assert\NotBlank()]
    public string $password;

    #[ORM\Column(type: 'string', unique: true)]
    #[Groups(['user'])]
    #[Assert\Email(message: 'Email {{ value }} не является валидным email.',)]
    public string $email;

    #[ORM\Column(type: 'json')]
    public array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(['user'])]
    #[Assert\Date(message: "it's not date type")]
    public string $dateCreate;

    #[ORM\Column(type: 'string')]
    #[Groups(['user'])]
    #[Assert\Date(message: "it's not date type")]
    public string $dateUpdate;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    public Car $car;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
        // Если вы храните какие-либо временные конфиденциальные данные о пользователе, удалите их здесь.
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->name;
    }

    public function __toString(): string
    {
        return "User:" . " id:" . $this->id . ", name: " . $this->name . ", password: " . $this->password . ", date_create: " . $this->dateCreate . ", date_update: " . $this->dateUpdate;
    }

    /**
     * @param string $name
     * @param string $password
     * @param string $email
     */
    public function __construct(string $name,string $password,string $email)
    {
//         Закоммитить и убрать параметры если нужны фикстуры
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
        $this->car = new Car();
        $this->roles=['ROLE_USER'];
        $this->dateCreate = date('Y-m-d');
        $this->dateUpdate = date('Y-m-d');
    }


    /**
     * @param string $dateCreate
     */
    public function setDateCreate(string $dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getDateCreate(): string
    {
        return $this->dateCreate;
    }


    /**
     * @return string
     */
    public function getDateUpdate(): string
    {
        return $this->dateUpdate;
    }

    /**
     * @param string $dateUpdate
     */
    public function setDateUpdate(string $dateUpdate): void
    {
        $this->dateUpdate = $dateUpdate;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }


}
