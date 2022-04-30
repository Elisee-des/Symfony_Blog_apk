<?php

namespace App\Entity;

use App\Repository\DepartementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartementsRepository::class)
 */
class Departements
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $number;

    /**
     * @ORM\OneToMany(targetEntity=Annonces::class, mappedBy="departements")
     */
    private $regions;

    /**
     * @ORM\ManyToOne(targetEntity=Regions::class, inversedBy="departements")
     */
    private $region;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection|Annonces[]
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Annonces $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
            $region->setDepartements($this);
        }

        return $this;
    }

    public function removeRegion(Annonces $region): self
    {
        if ($this->regions->removeElement($region)) {
            // set the owning side to null (unless already changed)
            if ($region->getDepartements() === $this) {
                $region->setDepartements(null);
            }
        }

        return $this;
    }

    public function getRegion(): ?Regions
    {
        return $this->region;
    }

    public function setRegion(?Regions $region): self
    {
        $this->region = $region;

        return $this;
    }
}
