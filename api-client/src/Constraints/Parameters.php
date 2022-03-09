<?php

namespace App\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\Parameter;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Parameters extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type(type: 'array'),
            new Assert\All([
                'constraints' => new Parameter
            ])
        ];
    }
}