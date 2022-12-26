<?php

namespace Tgu\Laperdina\Blog\Http\Auth;

use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Post;
use Tgu\Laperdina\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\AuthException;
use Tgu\Laperdina\Exceptions\HttpException;
use Tgu\Laperdina\Exceptions\InvalidArgumentExceptions;
use Tgu\Laperdina\Exceptions\UserNotFoundException;

class PasswordAuthentication implements PasswordAuthenticationInterface {
    private UsersRepositoryInterface $usersRepository;

    public function __construct($usersRepository) {
        $this->usersRepository = $usersRepository;
    }

    public function user(Request $request): User {
        try {
            $username = new UUID($request->jsonBodyField('username'));
        }
        catch (InvalidArgumentExceptions | HttpException$exception) {
            throw new AuthException($exception->getMessage());
        }

        try {
            $user = $this->usersRepository->getByUsername($username);
        }
        catch (UserNotFoundException $exception) {
            throw new AuthException($exception->getMessage());
        }

        try {
            $password = $request->jsonBodyField('password');
        }
        catch (InvalidArgumentExceptions | HttpException$exception) {
            throw new AuthException($exception->getMessage());
        }

        if (!$user->checkPassword($password)) {
            throw new AuthException('Wrong password');
        }

        return $user;
    }

    public function post(Request $request): Post {

    }
}