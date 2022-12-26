<?php

namespace Tgu\Laperdina\Blog\Http\Auth;

use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Post;
use Tgu\Laperdina\Blog\User;

interface AuthenticationInterface
{
    public function user(Request $request):User;

    public function post(Request $request):Post;

}