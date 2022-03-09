<?php

namespace App\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\{
    HttpMethod,
    PathItemTags,
    RequestBody,
    Responses,
    Parameter
};

#[Attribute(Attribute::TARGET_PROPERTY)]
class PathItem extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type(type: 'array'),
            new Assert\Collection([
                'httpMethod'    => new HttpMethod,
                'summary'       => new Assert\Optional(new Assert\Type(type: 'string')),
                'description'   => new Assert\Optional(new Assert\Type(type: 'string')),
                'tags'          => new Assert\Optional(new PathItemTags),
                'requestBody'   => new Assert\Optional(new RequestBody),
                'responses'     => new Assert\Optional(new Responses),
                'parameters'    => new Assert\Optional(new Parameters),
            ])
        ];
    }
}