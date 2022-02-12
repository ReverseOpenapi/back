<?php

namespace App\DTO\Document;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractDocument
{
    #[Ignore]
    private SerializerInterface $serializer;

    public function __construct()
    {
        $this->serializer = $this->initializeSerializer();
    }

    public function toJson(): string
    {
        return $this->serializer->serialize($this, 'json', [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]);
    }

    public function toYaml(): string
    {
        return "";
    }

    private function initializeSerializer(): SerializerInterface
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $defaultContext = [
            AbstractNormalizer::CALLBACKS => $this->getNormalizerCallbacks(),
        ];

        return new Serializer(
            [new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, null, null, null, null, $defaultContext)],
            ['json' => new JsonEncoder()]
        );
    }

    #[Ignore]
    protected function getNormalizerCallbacks(): array
    {
       return [];
    }
}