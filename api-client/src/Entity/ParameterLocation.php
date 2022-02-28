<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParameterLocation
 *
 * @ORM\Table(name="parameter_location")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ParameterLocationRepository")
 */
class ParameterLocation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     */
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }


}
