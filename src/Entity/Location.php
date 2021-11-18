<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location extends Basic
{
    /**
     * @ORM\Column(type="integer")
     */
    private $location_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $location_code_parent;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $country_iso_code;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $location_type;

    /**
     * @ORM\ManyToOne(targetEntity=System::class, inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $system;

    public function getLocationCode(): ?int
    {
        return $this->location_code;
    }

    public function setLocationCode(int $location_code): self
    {
        $this->location_code = $location_code;

        return $this;
    }

    public function getLocationName(): ?string
    {
        return $this->location_name;
    }

    public function setLocationName(string $location_name): self
    {
        $this->location_name = $location_name;

        return $this;
    }

    public function getLocationCodeParent(): ?int
    {
        return $this->location_code_parent;
    }

    public function setLocationCodeParent(?int $location_code_parent): self
    {
        $this->location_code_parent = $location_code_parent;

        return $this;
    }

    public function getCountryIsoCode(): ?string
    {
        return $this->country_iso_code;
    }

    public function setCountryIsoCode(string $country_iso_code): self
    {
        $this->country_iso_code = $country_iso_code;

        return $this;
    }

    public function getLocationType(): ?string
    {
        return $this->location_type;
    }

    public function setLocationType(string $location_type): self
    {
        $this->location_type = $location_type;

        return $this;
    }

    public function getSystem(): ?System
    {
        return $this->system;
    }

    public function setSystem(?System $system): self
    {
        $this->system = $system;

        return $this;
    }
}
