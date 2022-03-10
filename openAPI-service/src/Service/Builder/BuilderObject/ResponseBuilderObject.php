<?php

namespace App\Service\Builder\BuilderObject;

class ResponseBuilderObject
{
    private int $httpStatusCode;

    private ?string $description = null;

    /**
     * @var array<mixed>
     */
    private ?array $content = null;

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function setHttpStatusCode(int $httpStatusCode): ResponseBuilderObject
    {
        $this->httpStatusCode = $httpStatusCode;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): ResponseBuilderObject
    {
        $this->description = $description;
        return $this;
    }

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function setContent(?array $content): ResponseBuilderObject
    {
        $this->content = $content;
        return $this;
    }
}