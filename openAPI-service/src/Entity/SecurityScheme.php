<?php

namespace App\Entity;

use App\Repository\SecuritySchemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SecuritySchemeRepository::class)]
class SecurityScheme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $scheme;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $bearerFormat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $openIdConnectUrl;

    #[ORM\OneToMany(mappedBy: 'securityScheme', targetEntity: OAuthFlow::class, orphanRemoval: true)]
    private Collection $flows;

    #[ORM\ManyToOne(targetEntity: SecurityType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?SecurityType $type;

    #[ORM\ManyToOne(targetEntity: ApiKeyLocation::class)]
    private ?ApiKeyLocation $apiKeyLocation;

    #[ORM\ManyToOne(targetEntity: OpenApiDocument::class, inversedBy: 'securitySchemes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OpenApiDocument $openApiDocument;

    public function __construct()
    {
        $this->flows = new ArrayCollection();
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getScheme(): ?string
    {
        return $this->scheme;
    }

    public function setScheme(?string $scheme): self
    {
        $this->scheme = $scheme;

        return $this;
    }

    public function getBearerFormat(): ?string
    {
        return $this->bearerFormat;
    }

    public function setBearerFormat(?string $bearerFormat): self
    {
        $this->bearerFormat = $bearerFormat;

        return $this;
    }

    public function getOpenIdConnectUrl(): ?string
    {
        return $this->openIdConnectUrl;
    }

    public function setOpenIdConnectUrl(?string $openIdConnectUrl): self
    {
        $this->openIdConnectUrl = $openIdConnectUrl;

        return $this;
    }

    /**
     * @return Collection|OAuthFlow[]
     */
    public function getFlows(): Collection
    {
        return $this->flows;
    }

    public function addFlow(OAuthFlow $flow): self
    {
        if (!$this->flows->contains($flow)) {
            $this->flows[] = $flow;
            $flow->setSecurityScheme($this);
        }

        return $this;
    }

    public function removeFlow(OAuthFlow $flow): self
    {
        if ($this->flows->removeElement($flow)) {
            // set the owning side to null (unless already changed)
            if ($flow->getSecurityScheme() === $this) {
                $flow->setSecurityScheme(null);
            }
        }

        return $this;
    }

    public function getType(): ?SecurityType
    {
        return $this->type;
    }

    public function setType(?SecurityType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getApiKeyLocation(): ?ApiKeyLocation
    {
        return $this->apiKeyLocation;
    }

    public function setApiKeyLocation(?ApiKeyLocation $apiKeyLocation): self
    {
        $this->apiKeyLocation = $apiKeyLocation;

        return $this;
    }

    public function getOpenApiDocument(): ?OpenApiDocument
    {
        return $this->openApiDocument;
    }

    public function setOpenApiDocument(?OpenApiDocument $openApiDocument): self
    {
        $this->openApiDocument = $openApiDocument;

        return $this;
    }
}
