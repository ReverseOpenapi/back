<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PathItem
 *
 * @ORM\Table(name="path_item", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_7277AC49B1466FD3", columns={"request_body_id"})}, indexes={@ORM\Index(name="IDX_7277AC497A82E6BE", columns={"http_method_id"}), @ORM\Index(name="IDX_7277AC49D96C566B", columns={"path_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PathItemRepository")
 */
class PathItem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="summary", type="text", length=0, nullable=true)
     */
    private $summary;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var \HttpMethod
     *
     * @ORM\ManyToOne(targetEntity="HttpMethod")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="http_method_id", referencedColumnName="id")
     * })
     */
    private $httpMethod;

    /**
     * @var \RequestBody
     *
     * @ORM\ManyToOne(targetEntity="RequestBody")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="request_body_id", referencedColumnName="id")
     * })
     */
    private $requestBody;

    /**
     * @var \Path
     *
     * @ORM\ManyToOne(targetEntity="Path")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="path_id", referencedColumnName="id")
     * })
     */
    private $path;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="pathItem")
     * @ORM\JoinTable(name="path_item_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="path_item_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *   }
     * )
     */
    private $tag;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

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

    public function getHttpMethod(): ?HttpMethod
    {
        return $this->httpMethod;
    }

    public function setHttpMethod(?HttpMethod $httpMethod): self
    {
        $this->httpMethod = $httpMethod;

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

    public function getPath(): ?Path
    {
        return $this->path;
    }

    public function setPath(?Path $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }

}
