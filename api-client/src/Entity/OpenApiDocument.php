<?php

namespace App\Entity;

use App\Repository\OpenApiDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OpenApiDocumentRepository::class)]
class OpenApiDocument
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class:UuidGenerator::class)]
    private $id;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'openApiDocument', targetEntity: Path::class, orphanRemoval: true)]
    private Collection $paths;

    #[ORM\OneToMany(mappedBy: 'openApiDocument', targetEntity: Tag::class, orphanRemoval: true, cascade:["persist"])]
    private Collection $tags;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'string', length: 255)]
    private $version;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: 'string', length: 255)]
    private $userId;

    public function __construct(array $data = [])
    {

        if (count($data)) {
            $this->title        = $data['title'] ?? null;
            $this->description  = $data['description'] ?? '';
            $this->version      = $data['version'] ?? null;
            $this->userId       = $data['userId'] ?? null;
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

    public function removePath(Path $path): self
    {
        if ($this->paths->removeElement($path)) {
            // set the owning side to null (unless already changed)
            if ($path->getOpenApiDocument() === $this) {
                $path->setOpenApiDocument(null);
            }
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

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getOpenApiDocument() === $this) {
                $tag->setOpenApiDocument(null);
            }
        }

        return $this;
    }

    public function toArray() : array
    {
        return [
            'title'             => $this->title,
            'description'       => $this->description,
            'version'           => $this->version,
            'userId'            => $this->userId,
            'tags'              => array_map(function ($tag) {
                return $tag->toArray();
            }, $this->tags->toArray()),
        ];
    }
}
