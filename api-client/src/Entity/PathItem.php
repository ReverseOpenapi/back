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
    private int $id;

    #[ORM\Column(type: 'text', nullable: true)]
    private $summary;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 7)]
    private $httpMethod;

    #[ORM\OneToMany(mappedBy: 'pathItem', targetEntity: HttpResponse::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $responses;

    #[ORM\OneToOne(inversedBy: 'pathItem', targetEntity: RequestBody::class, cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private ?RequestBody $requestBody;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'pathItems')]
    private Collection $tags;

    #[ORM\OneToMany(mappedBy: 'pathItem', targetEntity: Parameter::class, cascade: ["persist"])]
    private Collection $parameters;

    #[ORM\ManyToOne(targetEntity: Path::class, inversedBy: 'pathItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Path $path;

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

    /**
     * @param  HttpResponse[] $responses
     */
    public function addResponses(array $responses): self
    {
        foreach ($responses as $response) {
            $this->addResponse($response);
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

    /**
     * @param  Tag[] $tags
     */
    public function addTags(array $tags): self
    {
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

    /**
     * @param  Parameter[] $parameters
     */
    public function addParameters(array $parameters): self
    {
        foreach ($parameters as $parameter) {
            $this->addParameter($parameter);
        }

        return $this;
    }

    public function toArray() {

        $baseEntity = [
            'summary'       => $this->summary,
            'description'   => $this->description,
            'httpMethod'    => $this->httpMethod,
        ];

        if(isset($this->requestBody)) $baseEntity['requestBody'] = $this->requestBody->toArray();

        if (count($this->responses)) {

            $baseEntity['responses'] = array_map(
                function ($response) {

                    return $response->toArray();
                },
                $this->responses->toArray()
            );
        }

        if (count($this->tags)) {

            $baseEntity['tags'] = array_map(
                function ($tag) {

                    return $tag->getName();
                },
                $this->tags->toArray()
            );
        }

        if (count($this->parameters)) {

            $baseEntity['parameters'] = array_map(
                function ($parameter) {

                    return $parameter->toArray();
                },
                $this->parameters->toArray()
            );
        }

        return $baseEntity;
    }
}
