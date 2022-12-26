<?php

namespace Tgu\Laperdina\Blog\Http\Actions\Users;

use Tgu\Laperdina\Blog\Http\Actions\ActionInterface;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Laperdina\Exceptions\HttpException;
use Tgu\Laperdina\Exceptions\UserNotFoundException;

class FindByUsername implements ActionInterface
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct($usersRepository) {
        $this->usersRepository = $usersRepository;
    }

    public function handle(Request $request): Response {
        try {
            $username = $request->query('username');
            $user =$this->usersRepository->getByUsername($username);
        }

        catch (HttpException | UserNotFoundException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        return new SuccessResponse(['username'=>$user->getUserName(),
            'name'=>$user->getName()->getFirstName().' '.$user->getName()->getLastName()]);
    }
}