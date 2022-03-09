<?php

namespace App\Entity;

use App\Repository\HttpResponseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: HttpResponseRepository::class)]
class HttpResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[ORM\Column(type: 'integer')]
    private ?int $httpStatusCode;

    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;


    #[Assert\Type(type: 'array')]
    #[ORM\Column(type: 'json', nullable: true)]
    private array $content;

    #[ORM\ManyToOne(targetEntity: PathItem::class, inversedBy: 'responses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PathItem $pathItem;


    public function __construct(array $data = []){
        if (count($data)) {
            $this->httpStatusCode   = $data['httpStatusCode'] ?? null;
            $this->description      = $data['description'] ?? null;
            $this->content          = $data['content'] ?? [];
        }
    }

    public function toArray(){
        return [
            'httpStatusCode'    => $this->httpStatusCode,
            'description'       => $this->description,
            'content'           => $this->content,
        ];
    }
    public function setPathItem(?PathItem $pathItem): self
    {
        $this->pathItem = $pathItem;

        return $this;
    }
}
