<?php

namespace App\Constraints\Tag;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Tag extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Collection([
                'name' => [
                    new Assert\NotBlank,
                    new Assert\Type(type: 'string'),
                ],
                'description' => new Assert\Type(type: 'string'),
            ])
        ];
    }
}