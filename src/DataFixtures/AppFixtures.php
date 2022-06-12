<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface  $encoder)
    {
     $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        for ($u=0;$u < 10 ;$u++){
            $user = new User();
            $chrono=1;
            $user->setFirstName($faker->firstName)
                 ->setLastName($faker->lastName)
                 ->setEmail($faker->email)
                 ->setPassword($this->encoder->hashPassword($user,"password"));
            $manager->persist($user);
            for ($c=0;$c < mt_rand(5,20) ;$c++){
                $customer = new Customer();
                $customer->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setCompany($faker->company)
                    ->setEmail($faker->email)
                    ->setUser($user);
                $manager->persist($customer);

                for ($i=0;$i < mt_rand(3,10) ;$i++){
                    $invoice = new Invoice();

                    $invoice->setAmount($faker->randomFloat(2,2500,10000))
                        ->setSendAt($faker->dateTimeBetween('- 6 months'))
                        ->setStatus($faker->randomElement(['SENT','PAID','CANCELLED']))
                        ->setCustomer($customer)
                        ->setChrono($chrono);
                    $chrono++;
                    $manager->persist($invoice);

                }
            }
        }
        $manager->flush();
    }
}
