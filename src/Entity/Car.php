<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=7)
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="integer")
     */
    private $place_number;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $fuel;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_commissioning;

    /**
     * @ORM\Column(type="integer")
     */
    private $level_fuel;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Society", inversedBy="cars")
     */
    private $society;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\KeyCar", mappedBy="car")
     */
    private $keys;

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

    public function getKeys(): ArrayCollection
    {
        return $this->keys;
    }
}
