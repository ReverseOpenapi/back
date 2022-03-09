<?php

namespace App\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\PathItems;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Path extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Collection([
                'endpoint'  => [
                    new Assert\NotBlank,
                    new Assert\Type(type: 'string')
                ],
                'pathItems' => new PathItems
            
            ])
        ];
    }
}