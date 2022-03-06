<?php

namespace App\Service\Builder\BuilderObject;

class OpenApiBuilderObject
{
    private InfoBuilderObject $info;

    /**
     * @var iterable<TagBuilderObject>|null
     */
    private ?iterable $tags = null;

    /**
     * @var iterable<PathItemBuilderObject>
     */
    private iterable $paths = [];

    public function getInfo(): InfoBuilderObject
    {
        return $this->info;
    }

    public function setInfo(InfoBuilderObject $info): self
    {
        $this->info = $info;
        return $this;
    }

    public function getTags(): iterable|null
    {
        return $this->tags;
    }

    public function addTag(TagBuilderObject $tag): self
    {
        if ($this->tags === null) {
            $this->tags = [];
        }

        array_push($this->tags ,$tag);
        return $this;
    }

    public function getPaths(): iterable
    {
        return $this->paths;
    }

    public function addPath(PathBuilderObject $path): self
    {
        array_push($this->paths ,$path);
        return $this;
    }
}
