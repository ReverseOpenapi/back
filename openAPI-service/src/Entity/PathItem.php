<?php

namespace App\Entity;

use App\Repository\PathItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PathItemRepository::class)]
class PathItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: Path::class, inversedBy: 'pathItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Path $path;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $summary;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\OneToMany(mappedBy: 'pathItem', targetEntity: HttpResponse::class, orphanRemoval: true)]
    private Collection $responses;

    #[ORM\Column(type: 'string', length: 7)]
    private ?string $httpMethod;

    // TODO: why is requestBody not initialized when lazy loaded and getter is called by hydrator ?
    #[ORM\OneToOne(inversedBy: 'pathItem', targetEntity: RequestBody::class, cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private ?RequestBody $requestBody;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'pathItems')]
    private Collection $tags;

    #[ORM\OneToMany(mappedBy: 'pathItem', targetEntity: Parameter::class, orphanRemoval: true)]
    private Collection $parameters;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->parameters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

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
     * @return Collection|HttpResponse[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(HttpResponse $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setPathItem($this);
        }

        return $this;
    }

    public function removeResponse(HttpResponse $response): self
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getPathItem() === $this) {
                $response->setPathItem(null);
            }
        }

        return $this;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function setHttpMethod(string $httpMethod): self
    {
        $this->httpMethod = $httpMethod;

        return $this;
    }

    public function getRequestBody(): ?RequestBody
    {
        return $this->requestBody;
    }

    public function setRequestBody(?RequestBody $requestBody): self
    {
        $this->requestBody = $requestBody;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, Parameter>
     */
    public function getParameters(): Collection
    {
        return $this->parameters;
    }

    public function addParameter(Parameter $parameter): self
    {
        if (!$this->parameters->contains($parameter)) {
            $this->parameters[] = $parameter;
            $parameter->setPathItem($this);
        }

        return $this;
    }

    public function removeParameter(Parameter $parameter): self
    {
        if ($this->parameters->removeElement($parameter)) {
            // set the owning side to null (unless already changed)
            if ($parameter->getPathItem() === $this) {
                $parameter->setPathItem(null);
            }
        }

        return $this;
    }
}
