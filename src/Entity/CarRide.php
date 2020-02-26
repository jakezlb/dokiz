<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=255)
     */
    private $departure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $arrival;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $id_status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress_point_departure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress_point_arrival;

    /**
     * @ORM\Column(type="integer")
     */
    private $km_number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservation", inversedBy="carRides")
     */
    private $reservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeparture(): ?string
    {
        return $this->departure;
    }

    public function setDeparture(string $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getArrival(): ?string
    {
        return $this->arrival;
    }

    public function setArrival(string $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getIdStatus(): ?string
    {
        return $this->id_status;
    }

    public function setIdStatus(?string $id_status): self
    {
        $this->id_status = $id_status;

        return $this;
    }

    public function getAdressPointDeparture(): ?string
    {
        return $this->adress_point_departure;
    }

    public function setAdressPointDeparture(string $adress_point_departure): self
    {
        $this->adress_point_departure = $adress_point_departure;

        return $this;
    }

    public function getAdressPointArrival(): ?string
    {
        return $this->adress_point_arrival;
    }

    public function setAdressPointArrival(string $adress_point_arrival): self
    {
        $this->adress_point_arrival = $adress_point_arrival;

        return $this;
    }

    public function getKmNumber(): ?int
    {
        return $this->km_number;
    }

    public function setKmNumber(int $km_number): self
    {
        $this->km_number = $km_number;

        return $this;
    }

    public function getReservation() : ?Reservation
    {
        return $this->reservation;
    }

    private function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

}
