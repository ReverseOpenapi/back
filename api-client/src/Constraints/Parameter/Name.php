<?php

namespace App\Constraints\Parameter;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;


#[Attribute(Attribute::TARGET_PROPERTY)]
class Name extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank,
            new Assert\Type(type: 'string'),
        ];
    }
}