<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends BaseFixture
{
    public function __construct(
        public UserPasswordHasherInterface $hasher,
    )
    {
    }


    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 10, function (User $user, $count) {
            $user_name = 'user' . rand(1, 100000);
            $user->setName($user_name);
            $user->setPassword($this->hasher->hashPassword($user,rand(1, 131414)));
            $user->setEmail($user_name . "@webant.ru");
            $user->car = new Car();
            $user->roles=['ROLE_USER'];
            $user->dateCreate = date('Y-m-d');
            $user->dateUpdate = date('Y-m-d');
        });
        $manager->flush();
    }
}
