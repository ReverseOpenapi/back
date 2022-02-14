<?php

namespace App\Service\Hydrator;

class Hydrator implements HydratorInterface
{
    public function hydrateFromObject(object $object, object $objectToHydrate): object
    {
        $reflection = new \ReflectionClass($object);
        foreach ($reflection->getProperties() as $reflectionProperty) {
            $property = $reflectionProperty->getName();
            $setter = 'set'.$property;
            $getter = 'get'.$property;
            if (
                method_exists($objectToHydrate, $setter)
                && method_exists($object, $getter)
                && $reflectionProperty->getValue($object)
            ) {
                try {
                    $objectToHydrate->$setter($object->$getter());
                } catch (\TypeError $e) {

                }
            }
        }

        return $objectToHydrate;
    }
}