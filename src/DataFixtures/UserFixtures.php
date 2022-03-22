<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public const USER_REFERENCE1 = "user-1";
    public const USER_REFERENCE2 = "user-2";


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {


        // Add users
        $user1 = new User();
        $user1->setUsername("Luke")
            ->setPassword($this->passwordEncoder->encodePassword($user1, 'Password'));
        $manager->persist($user1);



        $user2 = new User();
        $user2->setUsername("Jean-Marie")
            ->setPassword($this->passwordEncoder->encodePassword($user2, 'Password'));
        $manager->persist($user2);


        $manager->flush();
        $this->addReference(self::USER_REFERENCE1, $user1);
        $this->addReference(self::USER_REFERENCE2, $user2);
    }
}
