<?php

namespace App\Constraints\PathItem;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;


#[Attribute(Attribute::TARGET_PROPERTY)]
class HttpMethod extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank,
            new Assert\Choice([
                'GET',
                'POST',
                'DELETE',
                'PATCH',
                'PUT',
                'HEAD',
                'CONNECT',
                'OPTIONS',
                'TRACE'
            ])
        ];
    }
}