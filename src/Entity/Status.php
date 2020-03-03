<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 */
class Status
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
    private $wording;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CarRide", mappedBy="status")
     */
    private $CarRide;

    public function __construct()
    {
        $this->CarRide = new ArrayCollection();
    }

    public function __toString() {
        return $this->wording;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWording(): ?string
    {
        return $this->wording;
    }

    public function setWording(string $wording): self
    {
        $this->wording = $wording;

        return $this;
    }

    /**
     * @return Collection|CarRide[]
     */
    public function getCarRide(): Collection
    {
        return $this->CarRide;
    }

    public function addCarRide(CarRide $carRide): self
    {
        if (!$this->CarRide->contains($carRide)) {
            $this->CarRide[] = $carRide;
            $carRide->setStatus($this);
        }

        return $this;
    }

    public function removeCarRide(CarRide $carRide): self
    {
        if ($this->CarRide->contains($carRide)) {
            $this->CarRide->removeElement($carRide);
            // set the owning side to null (unless already changed)
            if ($carRide->getStatus() === $this) {
                $carRide->setStatus(null);
            }
        }

        return $this;
    }
}
