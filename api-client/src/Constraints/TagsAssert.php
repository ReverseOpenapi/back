<?php

namespace App\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\TagAssert;

#[Attribute(Attribute::TARGET_PROPERTY)]
class TagsAssert extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\All([
                'constraints' => new TagAssert
            ]),
            new Assert\Type(type: 'array')
        ];
    }
}