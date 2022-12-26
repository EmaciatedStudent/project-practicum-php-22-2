<?php

namespace Tgu\Laperdina\Blog\Repositories\AuthTokenRepository;

use Tgu\Laperdina\Blog\AuthToken;

interface AuthTokenRepositoryInterface
{
    public function save(AuthToken $authToken): void;

    public function get(string $token): AuthToken;
}