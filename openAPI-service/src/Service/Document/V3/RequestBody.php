<?php

namespace App\Service\Document\V3;

use Symfony\Component\Serializer\Annotation\SerializedName;

class RequestBody
{
    #[SerializedName("content")]
    private ?array $content = null;

    #[SerializedName("description")]
    private ?string $description = null;

    #[SerializedName("required")]
    private ?bool $required = null;

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function setContent(?array $content): self
    {
        $this->content['application/json']['schema'] = $content;
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

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(?bool $required): self
    {
        $this->required = $required;
        return $this;
    }
}