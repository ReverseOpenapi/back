<?php

namespace App\Constraints\PathItem;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\PathItem\PathItem;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PathItems extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type(type: 'array'),
            new Assert\All([
                'constraints' => new PathItem
            ]),
        ];
    }
}