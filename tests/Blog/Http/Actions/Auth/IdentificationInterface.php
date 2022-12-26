<?php

namespace Tgu\Laperdina\PhpUnit\Blog\Http\Auth;

use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\User;

interface AuthenticationInterface
{
    public function user(Request $request): User;
}