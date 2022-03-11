<?php

namespace App\Constraints\PathItem;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\Parameter\{Location, ParameterSchema, Name, Required, Description};

#[Attribute(Attribute::TARGET_PROPERTY)]
class Parameter extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type(type: 'array'),
            new Assert\Collection([
                'name'              => new Name,
                'required'          => new Required,
                'description'       => new Description,
                'location'          => new Location,
                'parameterSchema'   => new ParameterSchema,
            ])
        ];
    }
}