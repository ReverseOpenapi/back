<?php

namespace App\Entity;

use App\Repository\ParameterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ParameterRepository::class)]
class Parameter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'bool')]
    #[ORM\Column(type: 'boolean')]
    private ?bool $required;

    #[Assert\NotBlank]
    #[Assert\Choice(['query', 'header', 'path', 'cookie'])]
    #[ORM\Column(type: 'string', length: 6)]
    private ?string $location;

    #[ORM\ManyToOne(targetEntity: Path::class, inversedBy: 'parameters')]
    private ?Path $path;
    
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;


    #[Assert\NotBlank]
    #[Assert\Type(type: 'array')]
    #[Assert\Collection(
        fields: [
            'type' => [
                new Assert\NotBlank,
                new Assert\Type(type: 'string'),
                new Assert\Choice(['string', 'integer', 'boolean', 'number'])
            ]
        ],
        allowMissingFields: false
    )]
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


    public function getPath(): ?Path
    {
        return $this->path;
    }

    public function setPath(?Path $path): self
    {
        $this->path = $path;

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
