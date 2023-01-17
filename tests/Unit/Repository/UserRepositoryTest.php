<?php

namespace Unit\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use App\UserNotFoundException;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository();
    }

    public function provideUsernames(): iterable
    {
        yield ['john'];
        yield ['world'];
        yield ['conrad'];
    }

    /**
     * @dataProvider provideUsernames
     */
    public function testGetUserByName(string $name): void
    {
        $user = $this->userRepository->getUserByName($name);

        self::assertInstanceOf(User::class, $user);
    }

    public function testGetUserByNameThrowsUserNotFoundException(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->userRepository->getUserByName('not-existing');
    }

    public function testGetAllUsers():void
    {
        $allUsers = $this->userRepository->getAllUsers();

        $this->assertCount(3, $allUsers);
        $this->assertContainsOnlyInstancesOf(User::class, $allUsers);
    }

    /**
     * @dataProvider provideUsernames
     */
    public function testGetAllUsersExcept(string $name): void
    {
        $leftUsers = $this->userRepository->getAllUsersExcept($name);
        $this->assertCount(2, $leftUsers);
        $this->assertContainsOnlyInstancesOf(User::class, $leftUsers);
    }

    public function testGetAllUsersExceptThrowsUserNotFoundException(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->userRepository->getAllUsersExcept('not-existing');
    }
}
