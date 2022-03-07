<?php

namespace App\Entity;

use App\Repository\HttpResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HttpResponseRepository::class)]
class HttpResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'integer')]
    private ?int $httpStatusCode;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    /**
     * @var array<mixed>
     */
    #[ORM\Column(type: 'json', nullable: true)]
    private array $content = [];

    #[ORM\ManyToOne(targetEntity: PathItem::class, inversedBy: 'responses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PathItem $pathItem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHttpStatusCode(): ?int
    {
        return $this->httpStatusCode;
    }

    public function setHttpStatusCode(int $httpStatusCode): self
    {
        $this->httpStatusCode = $httpStatusCode;

        return $this;
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

    /**
     * @return array<mixed>|null
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param array<mixed>|null $content
     */
    public function setContent(?array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPathItem(): ?PathItem
    {
        return $this->pathItem;
    }

    public function setPathItem(?PathItem $pathItem): self
    {
        $this->pathItem = $pathItem;

        return $this;
    }
}
