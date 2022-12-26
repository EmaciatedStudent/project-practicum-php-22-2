<?php

namespace Tgu\Laperdina\Blog\Http\Actions\Users;

use Tgu\Laperdina\Blog\Http\Actions\ActionInterface;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Exceptions\HttpException;
use Tgu\Laperdina\Person\Name;

class CreateUser implements ActionInterface
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct($usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function handle(Request $request): Response {
        try {
            $user= User::createFrom(
                $request->jsonBodyField('username'),
                $request->jsonBodyField('password'),
                new Name(
                    $request->jsonBodyField('first_name'),
                    $request->jsonBodyField('last_name')
                ));
        }
        catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }
        $this->usersRepository->save($user);
        return new SuccessResponse(['uuid' => (string)$user->getUuid()]);
    }

}