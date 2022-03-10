<?php

namespace App\Service\Builder\BuilderObject;

class PathBuilderObject
{
    private string $endpoint;

    /**
     * @var iterable<PathItemBuilderObject>
     */
    private iterable $pathItems = [];

    /**
     * @var iterable<ParameterBuilderObject>
     */
    private iterable $parameters = [];

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): PathBuilderObject
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function addPathItem(PathItemBuilderObject $pathItem): self
    {
        array_push($this->pathItems, $pathItem);

        return $this;
    }

    /**
     * @return iterable<PathItemBuilderObject>
     */
    public function getPathItems(): iterable
    {
        return $this->pathItems;
    }

    public function getParameters(): iterable
    {
        return $this->parameters;
    }

    public function addParameter(ParameterBuilderObject $parameter): self
    {
        array_push($this->parameters, $parameter);
        return $this;
    }
}