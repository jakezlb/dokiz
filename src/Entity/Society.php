<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocietyRepository")
 */
class Society
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
    private $siret;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $social_reason;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $head_office;

      /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email_interlocutor;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $tel_interlocutor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Car", mappedBy="society")
     */
    private $cars;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SentEmail", mappedBy="society")
     */
    private $sentEmails;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="society")
     */
    private $users;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function __toString() {
        return $this->social_reason;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getSocialReason(): ?string
    {
        return $this->social_reason;
    }

    public function setSocialReason(string $social_reason): self
    {
        $this->social_reason = $social_reason;

        return $this;
    }

    public function getHeadOffice(): ?string
    {
        return $this->head_office;
    }

    public function setHeadOffice(string $head_office): self
    {
        $this->head_office = $head_office;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postal_code;
    }

    public function setPostalCode(?int $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getEmailInterlocutor(): ?string
    {
        return $this->email_interlocutor;
    }

    public function setEmailInterlocutor(?string $email_interlocutor): self
    {
        $this->email_interlocutor = $email_interlocutor;

        return $this;
    }

    public function getTelInterlocutor(): ?string
    {
        return $this->tel_interlocutor;
    }

    public function setTelInterlocutor(?string $tel_interlocutor): self
    {
        $this->tel_interlocutor = $tel_interlocutor;

        return $this;
    }

    public function getCars(): ArrayCollection
    {
        return $this->cars;
    }

    public function getSentEmails(): ArrayCollection
    {
        return $this->sentEmails;
    }

    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }
    
}
