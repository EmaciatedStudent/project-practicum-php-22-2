<?php

namespace Tgu\Laperdina\Blog\Http\Actions\Users;

use Tgu\Laperdina\Blog\Http\Actions\ActionInterface;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\HttpException;

class CreateUser implements ActionInterface
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct($usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function handle(Request $request): Response {
        try {
            $newUserUuid = UUID::random();
            $user = new User($newUserUuid,new Name($request->jsonBodyFind('first_name'), $request->jsonBodyFind('last_name')), $request->jsonBodyFind('username'));
        }

        catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->usersRepository->save($user);
        return new SuccessResponse(['uuid'=>(string)$newUserUuid]);
    }

}