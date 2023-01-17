<?php

namespace App\Repository;

use App\Entity\User;
use App\UserNotFoundException;

class UserRepository
{
    private static array $users = ['john', 'world', 'conrad'];

    /**
     * @return User
     * @throws UserNotFoundException
     */
    public function getUserByName(string $name)
    {
        if (in_array($name, self::$users, true)) {
            return new User($name);
        }

        throw new UserNotFoundException(
            sprintf('User with name [%s] not found', $name)
        );
    }

    /**
     * @return array<array-key, User>
     */
    public function getAllUsers(): array
    {
        return array_map(
            static fn(string $name): User => new User($name),
            self::$users
        );
    }

    /**
     * @return array<array-key, User>
     * @throws UserNotFoundException
     */
    public function getAllUsersExcept(string $name): array
    {
        $leftOutUser = $this->getUserByName($name);

        return array_filter(
            $this->getAllUsers(),
            static fn(User $user) => $user->name !== $leftOutUser->name
        );
    }
}
