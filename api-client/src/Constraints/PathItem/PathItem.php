<?php

namespace App\Constraints\PathItem;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\PathItem\{
    HttpMethod,
    Tags,
    RequestBody,
    Responses,
    Parameters
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
                'tags'          => new Assert\Optional(new Tags),
                'requestBody'   => new Assert\Optional(new RequestBody),
                'responses'     => new Assert\Optional(new Responses),
                'parameters'    => new Assert\Optional(new Parameters),
            ])
        ];
    }
}