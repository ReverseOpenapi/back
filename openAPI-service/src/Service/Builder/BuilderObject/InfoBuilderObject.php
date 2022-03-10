<?php

namespace App\Service\Builder\BuilderObject;

class InfoBuilderObject
{
    private string $title;

    private string $version;

    private ?string $description = null;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): InfoBuilderObject
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): InfoBuilderObject
    {
        $this->description = $description;
        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }
}