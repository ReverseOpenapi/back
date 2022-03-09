<?php

namespace App\Entity;

use App\Repository\ParameterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParameterRepository::class)]
class Parameter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[Description]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'boolean')]
    private ?bool $required;

    #[ORM\Column(type: 'string', length: 6)]
    private ?string $location;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: PathItem::class, inversedBy: 'parameters')]
    private ?PathItem $pathItem;

    #[ORM\Column(type: 'json')]
    private array $parameterSchema;


    public function __construct(array $data = []){

        if (count($data)) {
            $this->description          = $data['description'] ?? null;
            $this->required             = $data['required'] ?? null;
            $this->location             = $data['location'] ?? null;
            $this->name                 = $data['name'] ?? null;
            $this->parameterSchema      = $data['parameterSchema'] ?? [];

        }
    }

    public function setPathItem(?PathItem $pathItem): self
    {
        $this->pathItem = $pathItem;

        return $this;
    }

    public function toArray() {
        return [
            'description'       => $this->description,
            'required'          => $this->required,
            'location'          => $this->location,
            'name'              => $this->name,
            'parameterSchema'   => $this->parameterSchema,
        ];
    }
}
