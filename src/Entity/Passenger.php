<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PassengerRepository")
 */
class Passenger
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_driver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="passengers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CarRide", inversedBy="passengers" )
     * @ORM\JoinColumn(nullable=false)
     */
    private $CarRide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsDriver(): ?bool
    {
        return $this->is_driver;
    }

    public function setIsDriver(bool $is_driver): self
    {
        $this->is_driver = $is_driver;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getCarRide(): ?CarRide
    {
        return $this->CarRide;
    }

    public function setCarRide(?CarRide $CarRide): self
    {
        $this->CarRide = $CarRide;

        return $this;
    }
}
