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
     * @Assert\NotBlank
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="datetime")
     */
    private $date_end;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $postal_code_point_departure;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $city_point_departure;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $adress_point_departure;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $postal_code_point_arrival;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $city_point_arrival;

    /**
     * @Assert\NotBlank
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Passenger", mappedBy="CarRide", orphanRemoval=true)
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

    public function getId(): ?int
    {
        return $this->id;
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

    public function removePassenger(Passenger $passenger): self
    {
        if ($this->passengers->contains($passenger)) {
            $this->passengers->removeElement($passenger);
            // set the owning side to null (unless already changed)
            if ($passenger->getCarRide() === $this) {
                $passenger->setCarRide(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostalCodePointDeparture()
    {
        return $this->postal_code_point_departure;
    }

    /**
     * @param mixed $postal_code_point_departure
     */
    public function setPostalCodePointDeparture($postal_code_point_departure): void
    {
        $this->postal_code_point_departure = $postal_code_point_departure;
    }

    /**
     * @return mixed
     */
    public function getCityPointDeparture()
    {
        return $this->city_point_departure;
    }

    /**
     * @param mixed $city_point_departure
     */
    public function setCityPointDeparture($city_point_departure): void
    {
        $this->city_point_departure = $city_point_departure;
    }

    /**
     * @return mixed
     */
    public function getPostalCodePointArrival()
    {
        return $this->postal_code_point_arrival;
    }

    /**
     * @param mixed $postal_code_point_arrival
     */
    public function setPostalCodePointArrival($postal_code_point_arrival): void
    {
        $this->postal_code_point_arrival = $postal_code_point_arrival;
    }

    /**
     * @return mixed
     */
    public function getCityPointArrival()
    {
        return $this->city_point_arrival;
    }

    /**
     * @param mixed $city_point_arrival
     */
    public function setCityPointArrival($city_point_arrival): void
    {
        $this->city_point_arrival = $city_point_arrival;
    }
}
