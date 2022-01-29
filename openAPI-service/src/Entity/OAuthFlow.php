<?php

namespace App\Entity;

use App\Repository\OAuthFlowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OAuthFlowRepository::class)]
class OAuthFlow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $authorizationUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $tokenUrl;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $refreshUrl;

    #[ORM\OneToMany(mappedBy: 'flow', targetEntity: OAuthScope::class, orphanRemoval: true)]
    private Collection $scopes;

    #[ORM\ManyToOne(targetEntity: OAuthFlowType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?OAuthFlowType $type;

    #[ORM\ManyToOne(targetEntity: SecurityScheme::class, inversedBy: 'flows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SecurityScheme $securityScheme;

    public function __construct()
    {
        $this->scopes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorizationUrl(): ?string
    {
        return $this->authorizationUrl;
    }

    public function setAuthorizationUrl(string $authorizationUrl): self
    {
        $this->authorizationUrl = $authorizationUrl;

        return $this;
    }

    public function getTokenUrl(): ?string
    {
        return $this->tokenUrl;
    }

    public function setTokenUrl(string $tokenUrl): self
    {
        $this->tokenUrl = $tokenUrl;

        return $this;
    }

    public function getRefreshUrl(): ?string
    {
        return $this->refreshUrl;
    }

    public function setRefreshUrl(?string $refreshUrl): self
    {
        $this->refreshUrl = $refreshUrl;

        return $this;
    }

    /**
     * @return Collection|OAuthScope[]
     */
    public function getScopes(): Collection
    {
        return $this->scopes;
    }

    public function addScope(OAuthScope $scope): self
    {
        if (!$this->scopes->contains($scope)) {
            $this->scopes[] = $scope;
            $scope->setFlow($this);
        }

        return $this;
    }

    public function removeScope(OAuthScope $scope): self
    {
        if ($this->scopes->removeElement($scope)) {
            // set the owning side to null (unless already changed)
            if ($scope->getFlow() === $this) {
                $scope->setFlow(null);
            }
        }

        return $this;
    }

    public function getType(): ?OAuthFlowType
    {
        return $this->type;
    }

    public function setType(?OAuthFlowType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSecurityScheme(): ?SecurityScheme
    {
        return $this->securityScheme;
    }

    public function setSecurityScheme(?SecurityScheme $securityScheme): self
    {
        $this->securityScheme = $securityScheme;

        return $this;
    }
}
