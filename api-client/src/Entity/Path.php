<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Path
 *
 * @ORM\Table(name="path", indexes={@ORM\Index(name="IDX_B548B0F2D58E2A8", columns={"open_api_document_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PathRepository")
 */
class Path
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
     * @var string
     *
     * @ORM\Column(name="endpoint", type="string", length=255, nullable=false)
     */
    private $endpoint;

    /**
     * @var \OpenApiDocument
     *
     * @ORM\ManyToOne(targetEntity="OpenApiDocument")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="open_api_document_id", referencedColumnName="id")
     * })
     */
    private $openApiDocument;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getOpenApiDocument(): ?OpenApiDocument
    {
        return $this->openApiDocument;
    }

    public function setOpenApiDocument(?OpenApiDocument $openApiDocument): self
    {
        $this->openApiDocument = $openApiDocument;

        return $this;
    }


}
