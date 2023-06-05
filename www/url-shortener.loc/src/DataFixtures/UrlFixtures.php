<?php

namespace App\DataFixtures;

use App\Entity\Url;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UrlFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {

            $date = $faker->dateTimeInInterval('-2 days','+1 week');
            $manager->persist(
                (new Url())
                    ->setUrl($faker->url())
                    ->setTtl(86400)
                    ->setHash($date->format('YmdHis'))
                    ->setCreatedDate((new \DateTimeImmutable())->setTimestamp($date->getTimestamp()))
                    ->setIsExpired(false)
                    ->setIsSendToEndpoint(false)
            );
        }

        $manager->flush();
    }
}
