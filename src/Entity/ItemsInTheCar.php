<?php

namespace App\Entity;

use App\Repository\ItemsInTheCarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ItemsInTheCarRepository::class)]
class ItemsInTheCar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['items'])]
    public ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'itemsInTheCars')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['items'])]
    public ?Car $car = null;

    #[ORM\Column(length: 45)]
    #[Groups(['items'])]
    #[Assert\Date(message: "it's not date type")]
    public ?string $dateCreate = null;

    #[ORM\Column(length: 45)]
    #[Groups(['items'])]
    #[Assert\Date(message: "it's not date type")]
    public ?string $dateUpdate = null;


    public function __construct(Car $car)
    {
        $this->car=$car;
        $this->dateCreate = date('Y-m-d');
        $this->dateUpdate = date('Y-m-d');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getDateCreate(): ?string
    {
        return $this->dateCreate;
    }

    public function setDateCreate(string $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getDateUpdate(): ?string
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(string $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }
}
