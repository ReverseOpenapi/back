<?php

namespace App\Service\Document;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractDocument
{
    #[Ignore]
    private SerializerInterface $serializer;

    #[Ignore]
    private string $id;

    public function __construct()
    {
        $this->serializer = $this->initializeSerializer();
    }

    /**
     * Generate the document in JSON format
     */
    public function toJson(): string
    {
        return $this->serializer->serialize($this, 'json', [
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        ]);
    }

    /**
     * Generate the document in YAML format
     */
    public function toYaml(): string
    {
        $flags = Yaml::DUMP_OBJECT_AS_MAP ^ Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE;
        return Yaml::dump(json_decode($this->toJson(), true), 10, 2, $flags);
    }

    private function initializeSerializer(): SerializerInterface
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        $defaultContext = [
            AbstractNormalizer::CALLBACKS => $this->getNormalizerCallbacks(),
        ];

        return new Serializer(
            [
                new ObjectNormalizer(
                    $classMetadataFactory,
                    $metadataAwareNameConverter,
                    null,
                    null,
                    null,
                    null,
                    $defaultContext
                )
            ],
            [
                'json' => new JsonEncoder()
            ]
        );
    }

    #[Ignore]
    protected function getNormalizerCallbacks(): array
    {
       return [];
    }

    #[Ignore]
    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
}