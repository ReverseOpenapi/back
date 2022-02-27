<?php

namespace App\Service\Document\V3;

use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Path
{
    #[Ignore]
    private string $endpoint;

    /**
     * @var iterable<Parameter>
     */
    #[SerializedName('parameters')]
    private ?iterable $parameters = null;

    /**
     * @var iterable<PathItem>
     */
    private iterable $pathItems = [];

    /**
     * @return iterable<PathItem>
     */
    public function getPathItems(): iterable
    {
        return $this->pathItems;
    }

    public function addPathItem(PathItem $pathItem): Path
    {
        array_push($this->pathItems, $pathItem);
        return $this;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): Path
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function getParameters(): ?iterable
    {
        return $this->parameters;
    }

    public function addParameter(Parameter $parameter): self
    {
        if ($this->parameters === null) {
            $this->parameters = [];
        }

        array_push($this->parameters, $parameter);
        return $this;
    }
}