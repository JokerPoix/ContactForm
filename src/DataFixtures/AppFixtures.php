<?php

namespace App\DataFixtures;
use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $encoder; 

    public function __construct( UserPasswordHasherInterface $encoder)
    {
        
        $this->encoder = $encoder;
        
    }
    public function load(ObjectManager $manager): void
    {
        $superAdmin = new Admin();
        $hash = $this->encoder->hashPassword($superAdmin, "password");
        $superAdmin->setUsername("superAdmin");
        $superAdmin->setPassword($hash);
        $superAdmin->setRoles(['ROLE_ADMIN']);
        $manager->persist($superAdmin);
        $manager->flush();
    }
}
