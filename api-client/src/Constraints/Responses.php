<?php

namespace App\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;
use App\Constraints\Response;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Responses extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type(type: 'array'),
            new Assert\All([
                'constraints' => new Response
            ])
        ];
    }
}