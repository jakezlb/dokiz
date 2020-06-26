<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="datetime")
     */
    private $date_reservation;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $status_key;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="datetime")
     */
    private $state_premise_depature;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="datetime")
     */
    private $state_premise_arrival;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="boolean")
     */
    private $is_confirmed;

    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CarRide", mappedBy="reservation")
     */
    private $carRides;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="reservations")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car", inversedBy="reservation")
     */
    private $cars;

    public function __construct()
    {
        $this->carRides = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->date_reservation;
    }

    public function setDateReservation(\DateTimeInterface $date_reservation): self
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }

    public function getStatusKey(): ?string
    {
        return $this->status_key;
    }

    public function setStatusKey(string $status_key): self
    {
        $this->status_key = $status_key;

        return $this;
    }

    public function getStatePremiseDepature(): ?\DateTimeInterface
    {
        return $this->state_premise_depature;
    }

    public function setStatePremiseDepature(\DateTimeInterface $state_premise_depature): self
    {
        $this->state_premise_depature = $state_premise_depature;

        return $this;
    }

    public function getStatePremiseArrival(): ?\DateTimeInterface
    {
        return $this->state_premise_arrival;
    }

    public function setStatePremiseArrival(\DateTimeInterface $state_premise_arrival): self
    {
        $this->state_premise_arrival = $state_premise_arrival;

        return $this;
    }

    public function getIsConfirmed(): ?bool
    {
        return $this->is_confirmed;
    }

    public function setIsConfirmed(bool $is_confirmed): self
    {
        $this->is_confirmed = $is_confirmed;

        return $this;
    }

    public function getCarRides(): Collection
    {
        return $this->carRides;
    }

    public function getUsers(): Collection
    {
        return  $this->users;
    }
    /**
     * @return mixed
     */
    public function getCars()
    {
        return $this->cars;
    }

    /**
     * @param mixed $cars
     */
    public function setCars($cars): void
    {
        $this->cars = $cars;
    }


    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addReservation($this);
        }
        return $this;
    }
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeReservation($this);
        }
        return $this;
    }
}
