<?php

namespace Tgu\Laperdina\Blog\Repositories\UsersRepository;

use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Blog\UUID;

interface UsersRepositoryInterface
{
    public function save(User $user):void;
    public function getByUsername(string $username):User;
    public function getByUuid(UUID $uuid): User;
}
