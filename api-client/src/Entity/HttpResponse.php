<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HttpResponse
 *
 * @ORM\Table(name="http_response", indexes={@ORM\Index(name="IDX_32C80BE6D5D96477", columns={"path_item_id"})})
 * @ORM\Entity
 * * @ORM\Entity(repositoryClass="App\Repository\HttpResponseRepository")
 */
class HttpResponse
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
     * @var int
     *
     * @ORM\Column(name="http_status_code", type="integer", nullable=false)
     */
    private $httpStatusCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var array|null
     *
     * @ORM\Column(name="content", type="json", nullable=true)
     */
    private $content;

    /**
     * @var \PathItem
     *
     * @ORM\ManyToOne(targetEntity="PathItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="path_item_id", referencedColumnName="id")
     * })
     */
    private $pathItem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHttpStatusCode(): ?int
    {
        return $this->httpStatusCode;
    }

    public function setHttpStatusCode(int $httpStatusCode): self
    {
        $this->httpStatusCode = $httpStatusCode;

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

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function setContent(?array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPathItem(): ?PathItem
    {
        return $this->pathItem;
    }

    public function setPathItem(?PathItem $pathItem): self
    {
        $this->pathItem = $pathItem;

        return $this;
    }


}
