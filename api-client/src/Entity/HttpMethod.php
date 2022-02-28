<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HttpMethod
 *
 * @ORM\Table(name="http_method")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\HttpMethodRepository")
 */
class HttpMethod
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
     * @ORM\Column(name="method", type="string", length=255, nullable=false)
     */
    private $method;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }


}
