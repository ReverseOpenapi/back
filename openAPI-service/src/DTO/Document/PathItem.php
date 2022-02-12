<?php

namespace App\DTO\Document;

use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;

class PathItem
{
    #[Ignore]
    private string $httpMethod;

    #[SerializedName('summary')]
    private ?string $summary = null;

    #[SerializedName('description')]
    private ?string $description = null;

    #[SerializedName('responses')]
    private iterable $responses = [];

    private ?RequestBody $requestBody = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): PathItem
    {
        $this->description = $description;
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): PathItem
    {
        $this->summary = $summary;
        return $this;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function setHttpMethod(string $httpMethod): PathItem
    {
        $this->httpMethod = $httpMethod;
        return $this;
    }

    public function getResponses(): iterable
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
       array_push($this->responses, $response);
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

}