<?php

namespace App\Entity;

use App\Repository\PathItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'text', nullable: true)]
    private $summary;

    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'pathItem', targetEntity: HttpResponse::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $responses;

    #[Assert\NotBlank]
    #[Assert\Choice([
        'GET',
        'POST',
        'DELETE',
        'PATCH',
        'PUT',
        'HEAD',
        'CONNECT',
        'OPTIONS',
        'TRACE'
    ])]
    #[ORM\Column(type: 'string', length: 7)]
    private $httpMethod;

    #[ORM\OneToOne(inversedBy: 'pathItem', targetEntity: RequestBody::class, cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private ?RequestBody $requestBody;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'pathItems')]
    private Collection $tags;

    #[ORM\OneToMany(mappedBy: 'pathItem', targetEntity: Parameter::class, cascade: ["persist"])]
    private Collection $parameters;

    public function __construct(array $data = [])
    {
        if(count($data)){

            $this->summary      = $data['summary'] ?? null;
            $this->description  = $data['description'] ?? null;
            $this->httpMethod   = $data['httpMethod'] ?? null;
        }

        $this->responses = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->parameters = new ArrayCollection();
    }

    public function setPath(?Path $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function addResponse(HttpResponse $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setPathItem($this);
        }

        return $this;
    }

    public function setRequestBody(?RequestBody $requestBody): self
    {
        $this->requestBody = $requestBody;

        return $this;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function addTags(array $tagsName) : self
    {
        $tags = $this->path->getOpenApiDocument()->getTags();
        
        $tags = array_filter($tags->toArray(), function($tag) use ($tagsName) {

            return in_array($tag->getName(), $tagsName);
        });

        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }

    public function addParameter(Parameter $parameter): self
    {
        if (!$this->parameters->contains($parameter)) {
            $this->parameters[] = $parameter;
            $parameter->setPathItem($this);
        }

        return $this;
    }

    public function toArray() {
        return [
            'summary'       => $this->summary,
            'description'   => $this->description,
            'httpMethod'    => $this->httpMethod,
            'requestBody'   => $this->requestBody->toArray(),
            'responses'     => array_map(function ($response) {
                return $response->toArray();
            }, $this->responses->toArray()),
            'tags'          => array_map(function ($tag) {
                return $tag->getName();
            }, $this->tags->toArray()),
            'parameters'    => array_map(function ($parameter) {
                return $parameter->toArray();
            }, $this->parameters->toArray()),
        ];
    }
}
