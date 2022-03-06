<?php

namespace App\Service\Builder;

use App\Service\Document\AbstractDocument;
use App\Service\Builder\BuilderObject\OpenApiBuilderObject;

/**
 * OpenAPI document builder
 *
 * It builds an OpenAPI document in a specific format from builders objects.
 */
interface BuilderInterface
{
    /**
     * Build an OpenAPI document from a builder object
     *
     * @param OpenApiBuilderObject $openApiBuilderObject
     * @return AbstractDocument the builded document
     */
    public function buildDocument(OpenApiBuilderObject $openApiBuilderObject): AbstractDocument;
}