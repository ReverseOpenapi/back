<?php

namespace App\Entity;

use App\Repository\RequestBodyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RequestBodyRepository::class)]
class RequestBody
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'array')]
    #[ORM\Column(type: 'json')]
    private array $content;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'bool')]
    #[ORM\Column(type: 'boolean')]
    private ?bool $required;

    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\OneToOne(mappedBy: 'requestBody', targetEntity: PathItem::class, cascade: ['persist', 'remove'])]
    private ?PathItem $pathItem;

    public function __construct(array $data = []){

        if (count($data)) {

            $this->required = $data['required'] ?? null;
            $this->description = $data['description'] ?? null;
            if(isset($data['content'])){
                $content = [
                    "type" =>  "object",
                    "properties" => $data['content']
                ];

                $this->content = $content;
            }
        }
    }

    public function setPathItem(?PathItem $pathItem): self
    {
        // unset the owning side of the relation if necessary
        if (null === $pathItem && null !== $this->pathItem) {
            $this->pathItem->setRequestBody(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $pathItem && $pathItem->getRequestBody() !== $this) {
            $pathItem->setRequestBody($this);
        }

        $this->pathItem = $pathItem;

        return $this;
    }

    public function toArray(){

        return [
            'content'       => $this->content,
            'required'      => $this->required,
            'description'   => $this->description,
        ];
    }
}
