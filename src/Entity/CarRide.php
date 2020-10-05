<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRideRepository")
 */
class CarRide
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Blank
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @Assert\Blank
     * @ORM\Column(type="datetime")
     */
    private $date_end;

    /**
     * @Assert\Blank
     * @Assert\Length(min=5, max=5, exactMessage="Le code postal doit faire 5 caractères.")
     * @ORM\Column(type="string", length=255)
     */
    private $start_postal_code;

    /**
     * @Assert\Blank
     * @ORM\Column(type="string", length=255)
     */
    private $start_city;

    /**
     * @Assert\Blank
     * @ORM\Column(type="string", length=255)
     */
    private $start_address;

    /**
     * @Assert\Blank
     * @Assert\Length(min=5, max=5, exactMessage="Le code postal doit faire 5 caractères.")
     * @ORM\Column(type="string", length=255)
     */
    private $end_postal_code;

    /**
     * @Assert\Blank
     * @ORM\Column(type="string", length=255)
     */
    private $end_city;

    /**
     * @Assert\Blank
     * @ORM\Column(type="string", length=255)
     */
    private $end_address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservation", inversedBy="carRides")
     */
    private $reservation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Passenger", mappedBy="CarRide",cascade={"persist", "remove"})
     */
    private $passengers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status", inversedBy="CarRide")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * @param mixed $date_start
     */
    public function setDateStart($date_start): void
    {
        $this->date_start = $date_start;
    }

    /**
     * @return mixed
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * @param mixed $date_end
     */
    public function setDateEnd($date_end): void
    {
        $this->date_end = $date_end;
    }

    /**
     * @return mixed
     */
    public function getStartPostalCode()
    {
        return $this->start_postal_code;
    }

    /**
     * @param mixed $start_postal_code
     */
    public function setStartPostalCode($start_postal_code): void
    {
        $this->start_postal_code = $start_postal_code;
    }

    /**
     * @return mixed
     */
    public function getStartCity()
    {
        return $this->start_city;
    }

    /**
     * @param mixed $start_city
     */
    public function setStartCity($start_city): void
    {
        $this->start_city = $start_city;
    }

    /**
     * @return mixed
     */
    public function getStartAddress()
    {
        return $this->start_address;
    }

    /**
     * @param mixed $start_address
     */
    public function setStartAddress($start_address): void
    {
        $this->start_address = $start_address;
    }

    /**
     * @return mixed
     */
    public function getEndPostalCode()
    {
        return $this->end_postal_code;
    }

    /**
     * @param mixed $end_postal_code
     */
    public function setEndPostalCode($end_postal_code): void
    {
        $this->end_postal_code = $end_postal_code;
    }

    /**
     * @return mixed
     */
    public function getEndCity()
    {
        return $this->end_city;
    }

    /**
     * @param mixed $end_city
     */
    public function setEndCity($end_city): void
    {
        $this->end_city = $end_city;
    }

    /**
     * @return mixed
     */
    public function getEndAddress()
    {
        return $this->end_address;
    }

    /**
     * @param mixed $end_address
     */
    public function setEndAddress($end_address): void
    {
        $this->end_address = $end_address;
    }

    /**
     * @return mixed
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * @param mixed $reservation
     */
    public function setReservation($reservation): void
    {
        $this->reservation = $reservation;
    }

    /**
     * @return Collection|Passenger[]
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(Passenger $passenger): self
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers[] = $passenger;
            $passenger->setCarRide($this);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}
