<?php

namespace App\Constraints\Path;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\PathItem\PathItems;
use App\Constraints\Path\Endpoint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Path extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Collection([
                'endpoint'  => new Endpoint,
                'pathItems' => new PathItems
            ])
        ];
    }
}