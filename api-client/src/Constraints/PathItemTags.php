<?php

namespace App\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;


#[Attribute(Attribute::TARGET_PROPERTY)]
class PathItemTags extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type(type: 'array'),
            new Assert\All([
                'constraints' => new Assert\Type(type: 'string')
            ])
        ];
    }
}