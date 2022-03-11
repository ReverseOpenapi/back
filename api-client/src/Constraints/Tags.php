<?php

namespace App\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\Tag\Tag;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Tags extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\All([
                'constraints' => new Tag
            ]),
            new Assert\Type(type: 'array')
        ];
    }
}