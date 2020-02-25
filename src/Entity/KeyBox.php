<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KeyBoxRepository")
 */
class KeyBox
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
    private $adress_key_box;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdressKeyBox(): ?string
    {
        return $this->adress_key_box;
    }

    public function setAdressKeyBox(string $adress_key_box): self
    {
        $this->adress_key_box = $adress_key_box;

        return $this;
    }
}
