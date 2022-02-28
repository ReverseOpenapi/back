<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parameter
 *
 * @ORM\Table(name="parameter", indexes={@ORM\Index(name="IDX_2A97911064D218E", columns={"location_id"}), @ORM\Index(name="IDX_2A979110D96C566B", columns={"path_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ParameterRepository")
 */
class Parameter
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
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="required", type="boolean", nullable=false)
     */
    private $required;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(name="parameter_schema", type="json", nullable=false)
     */
    private $parameterSchema;

    /**
     * @var \ParameterLocation
     *
     * @ORM\ManyToOne(targetEntity="ParameterLocation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;

    /**
     * @var \Path
     *
     * @ORM\ManyToOne(targetEntity="Path")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="path_id", referencedColumnName="id")
     * })
     */
    private $path;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
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

    public function getParameterSchema(): ?array
    {
        return $this->parameterSchema;
    }

    public function setParameterSchema(array $parameterSchema): self
    {
        $this->parameterSchema = $parameterSchema;

        return $this;
    }

    public function getLocation(): ?ParameterLocation
    {
        return $this->location;
    }

    public function setLocation(?ParameterLocation $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getPath(): ?Path
    {
        return $this->path;
    }

    public function setPath(?Path $path): self
    {
        $this->path = $path;

        return $this;
    }


}
