<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'car')]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['car'])]
    public ?int $id;

//    #[ORM\Column]
//    private ?int $itemsInTheCar;

    #[ORM\Column(length: 45)]
    #[Groups(['car'])]
    #[Assert\Date(message: "it's not date type")]
    public ?string $dateCreate;


    #[ORM\Column(length: 45)]
    #[Groups(['car'])]
    public ?string $dateUpdate;


    #[ORM\OneToOne(mappedBy: 'car', cascade: ['persist', 'remove'])]
    #[Groups(['car'])]
    public ?User $user;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: ItemsInTheCar::class, cascade: ['persist'])]
    public ?Collection $itemsInTheCars;


    /**
     * @throws ORMException
     */
    public function __construct()
    {
        $this->dateCreate = date('Y-m-d');
        $this->dateUpdate = date('Y-m-d');
        $this->itemsInTheCars=new ArrayCollection();
        $this->addItemsInTheCar(new ItemsInTheCar($this));
//        $this->getItemsInTheCars()->add();
//        dd($this->getItemsInTheCars());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user->id;
    }

    public function setUserId(int $userId): self
    {
        $this->user->userId = $userId;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        // set the owning side of the relation if necessary
        if ($user->getCar() !== $this) {
            $user->setCar($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ItemsInTheCar>
     */
    public function getItemsInTheCars(): Collection
    {
        return $this->itemsInTheCars;
    }

    public function addItemsInTheCar(ItemsInTheCar $itemsInTheCar): self
    {
        if (!$this->itemsInTheCars->contains($itemsInTheCar)) {
            $this->itemsInTheCars->add($itemsInTheCar);
            $itemsInTheCar->setCar($this);
        }

        return $this;
    }

    public function removeItemsInTheCar(ItemsInTheCar $itemsInTheCar): self
    {
        if ($this->itemsInTheCars->removeElement($itemsInTheCar)) {
            // set the owning side to null (unless already changed)
            if ($itemsInTheCar->getCar() === $this) {
                $itemsInTheCar->setCar(null);
            }
        }

        return $this;
    }
}
