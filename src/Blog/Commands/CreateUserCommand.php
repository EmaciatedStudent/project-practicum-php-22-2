<?php

namespace Tgu\Laperdina\Blog\Commands;

use Tgu\Laperdina\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\CommandException;
use Tgu\Laperdina\Exceptions\UserNotFoundException;
use Tgu\Laperdina\Person\Name;

class CreateUserCommand
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct($usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function handle(Arguments $arguments):void{
        $username = $arguments->get('username');
        if($this->userExist($username)){
            throw new CommandException("User already exists: $username");
        }
        $this->usersRepository->save(new User(
            UUID::random(),
            new Name($arguments->get('first_name'), $arguments->get('last_name')),
            $username));
    }
    public function userExist(string $username):bool{
        try{
            $this->usersRepository->getByUsername($username);
        }
        catch (UserNotFoundException $exception){
            return false;
        }
        return true;
    }
}
