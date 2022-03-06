<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $loader = new \Nelmio\Alice\Loader\NativeLoader();
        $objectSet = $loader->loadFile(__DIR__ . '/AppFixtures.yaml')->getObjects();
        foreach ($objectSet as $object) {
            $manager->persist($object);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['app'];
    }
}
