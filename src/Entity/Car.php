<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=7)
     */
    private $immatriculation;

    /**
     * 
     * @ORM\Column(type="string", length=255)
     */
    
    private $carUrl;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private $place_number;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $fuel;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $parked;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $assurance;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $technical_control;

    /**
     * @ORM\Column(type="text", length=1000)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_commissioning;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Society", inversedBy="cars")
     */
    private $society;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\KeyCar", mappedBy="car",cascade={"persist", "remove"})
     */
    private $keys;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="cars")
     */
    private $reservation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_reservation_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_reservation_date;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $mark;

    public function __construct()
    {
        $this->keys = new ArrayCollection();        
    }

    public function __toString() {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getPlaceNumber(): ?int
    {
        return $this->place_number;
    }

    public function setPlaceNumber(int $place_number): self
    {
        $this->place_number = $place_number;

        return $this;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(?string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getParked(): ?string
    {
        return $this->parked;
    }

    public function setParked(?string $parked): self
    {
        $this->parked = $parked;

        return $this;
    }
    public function getAssurance(): ?string
    {
        return $this->assurance;
    }

    public function setAssurance(?string $assurance): self
    {
        $this->assurance = $assurance;

        return $this;
    }
    public function getTechnicalControl(): ?\DateTimeInterface
    {
        return $this->technical_control;
    }

    public function setTechnicalControl(\DateTimeInterface $technical_control): self
    {
        $this->technical_control = $technical_control;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCommissioning(): ?\DateTimeInterface
    {
        return $this->date_commissioning;
    }

    public function setDateCommissioning(\DateTimeInterface $date_commissioning): self
    {
        $this->date_commissioning = $date_commissioning;

        return $this;
    }

    public function getSociety() : ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $society): self
    {
        $this->society = $society;

        return $this;
    }

    public function getKeys()
    {
        return $this->keys;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
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
     * @return mixed
     */
    public function getCarUrl()
    {
        return $this->carUrl;
    }
    /**
     * @return mixed
     */
    public function getStartReservationDate()
    {
        return $this->start_reservation_date;
    }

    /**
     * @param mixed $start_reservation_date
     */
    public function setStartReservationDate($start_reservation_date): void
    {
        $this->start_reservation_date = $start_reservation_date;
    }

    /**
     * @return mixed
     */
    public function getEndReservationDate()
    {
        return $this->end_reservation_date;
    }

    /**
     * @param mixed $end_reservation_date
     */
    public function setEndReservationDate($end_reservation_date): void
    {
        $this->end_reservation_date = $end_reservation_date;
    }

    /**
     * @param mixed $carUrl
     */
    public function setCarUrl($carUrl)
    {
        $this->carUrl = $carUrl;

        return $this;
    }

    public function addKey(KeyCar $keyCar)
    {
        //$this->keys->add($keyCar);
        $keyCar->setCar($this);
        $this->keys->add($keyCar);
    }
    public function removeKey(KeyCar $keyCar)
    {
        $this->keys->removeElement($keyCar);
    }


}
