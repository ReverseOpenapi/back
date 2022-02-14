<?php

namespace App\Service\Document\V3;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Parameter
{
    #[SerializedName('name')]
    private string $name;

    #[SerializedName('in')]
    private string $location;

    #[SerializedName('description')]
    private ?string $description = null;

    #[SerializedName('required')]
    private bool $required;

    #[SerializedName('schema')]
    private array $schema;

    public function getSchema(): array
    {
        return $this->schema;
    }

    public function setSchema(array $schema): self
    {
        $this->schema = $schema;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
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

    public function getRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;
        return $this;
    }
}