<?php

namespace App\Entity;

use App\Repository\OpenApiDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;


#[ORM\Entity(repositoryClass: OpenApiDocumentRepository::class)]
class OpenApiDocument
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class:UuidGenerator::class)]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $version;

    #[ORM\OneToMany(mappedBy: 'openApiDocument', targetEntity: Path::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $paths;

    #[ORM\OneToMany(mappedBy: 'openApiDocument', targetEntity: Tag::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $tags;


    public function __construct(array $data = [])
    {

        if (count($data)) {
            $this->title        = $data['title'] ?? null;
            $this->description  = $data['description'] ?? '';
            $this->version      = $data['version'] ?? null;
        }

        $this->paths = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }


    public function getId() {

        return $this->id;
    }

    /**
     * @return Collection|Path[]
     */
    public function getPaths(): Collection
    {
        return $this->paths;
    }

    public function addPath(Path $path): self
    {
        if (!$this->paths->contains($path)) {
            $this->paths[] = $path;
            $path->setOpenApiDocument($this);
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setOpenApiDocument($this);
        }

        return $this;
    }

    public function toArray() : array
    {
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'description'       => $this->description,
            'version'           => $this->version,
            'tags'              => array_map(function ($tag) {
                return $tag->toArray();
            }, $this->tags->toArray()),
            'paths'              => array_map(function ($path) {
                return $path->toArray();
            }, $this->paths->toArray()),
        ];
    }
}
