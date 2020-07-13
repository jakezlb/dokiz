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
     * @ORM\Column(type="datetime")
     */
    private $date_commissioning;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private $level_fuel;   

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Society", inversedBy="cars")
     */
    private $society;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\KeyCar", mappedBy="car",cascade={"persist"})
     */
    private $keys;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="cars")
     */
    private $reservation;

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

    public function getDateCommissioning(): ?\DateTimeInterface
    {
        return $this->date_commissioning;
    }

    public function setDateCommissioning(\DateTimeInterface $date_commissioning): self
    {
        $this->date_commissioning = $date_commissioning;

        return $this;
    }

    public function getLevelFuel(): ?int
    {
        return $this->level_fuel;
    }

    public function setLevelFuel(int $level_fuel): self
    {
        $this->level_fuel = $level_fuel;

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
