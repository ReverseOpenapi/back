<?php

namespace App\Entity;

use App\Repository\RequestBodyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestBodyRepository::class)]
class RequestBody
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var array<mixed>
     */
    #[ORM\Column(type: 'json')]
    private array $content = [];

    #[ORM\Column(type: 'boolean')]
    private ?bool $required = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(mappedBy: 'requestBody', targetEntity: PathItem::class, cascade: ['persist', 'remove'])]
    private ?PathItem $pathItem;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array<mixed>|null
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param array<mixed> $content
     */
    public function setContent(array $content): self
    {
        $this->content = $content;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPathItem(): ?PathItem
    {
        return $this->pathItem;
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
}
