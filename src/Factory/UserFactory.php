<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as PasswordHasher;

class UserFactory
{
    public function __construct(
        private readonly PasswordHasher $passwordHasher,
    ) {}

    public function createUser(
        string $username,
        string $firstName,
        string $lastName,
        string $password,
        string $email,
        string $role = 'ROLE_USER',
    ): User
    {
        $user = new User();

        $user->setUsername($username)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPassword($this->passwordHasher->hashPassword($user, $password))
            ->addRole($role)
            ->setEmail($email)
        ;

        return $user;
    }
}
