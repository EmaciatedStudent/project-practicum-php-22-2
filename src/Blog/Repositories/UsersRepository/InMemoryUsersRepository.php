<?php

namespace Tgu\Laperdina\Blog\Repositories\UsersRepository;

use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\UserNotFoundException;

class InMemoryUsersRepository implements UsersRepositoryInterface
{
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function getByUsername(string $username): User
    {
        foreach ($this->users as $user) {
            if ((string)$user->getUsername() === $username)
                return $user;
        }
        throw new UserNotFoundException("Users not found $username");
    }

    public function getByUuid(UUID $uuid): User
    {
        foreach ($this->users as $user) {
            if ((string)$user->getUuid() === $uuid)
                return $user;
        }
        throw new UserNotFoundException("Users not found $uuid");
    }
}