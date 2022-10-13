<?php

namespace App\DataFixtures;

use App\Entity\Kid;
use App\Entity\States\Kid\Newborn;
use App\Enum\Sex;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When('dev')]
#[When('test')]
class KidFixtures extends Fixture
{
    protected Generator $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $state = new Newborn();
            $kid = new Kid($state);
            $kid
                ->setName($this->faker->firstName)
                ->setDateOfBirth($this->faker->dateTimeBetween('-10 years'))
                ->setSex(Sex::Male);

            $manager->persist($state);
            $manager->persist($kid);
        }

        $manager->flush();
    }
}