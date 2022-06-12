<?php


namespace App\DataFixturess;


use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($c=0;$c < 30 ;$c++){
            $customer = new Customer();
            $customer->setFirstName($faker->firstName)
                     ->setLastName($faker->lastName)
                     ->setCompany($faker->company)
                     ->setEmail($faker->email);

        }
        $manager->flush();
    }
}