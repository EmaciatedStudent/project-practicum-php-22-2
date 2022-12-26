<?php

namespace Tgu\Laperdina\PhpUnit\Blog\Http\Actions\Users;

use PHPUnit\Framework\TestCase;
use Tgu\Laperdina\Blog\Http\Actions\Users\FindByUsername;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\UserNotFoundException;
use Tgu\Laperdina\Person\Name;

class FindByUsernameActionTest extends TestCase {
    private function userRepository(array $users): UsersRepositoryInterface {
        return new class($users) implements UsersRepositoryInterface {
            private array $users;

            public function __construct($users)
            {
                $this->users = $users;
            }

            public function save(User $user): void {
            }

            public function getByUsername(string $username): User {
                foreach ($this->users as $user) {
                    if($user instanceof User && $username===$user->getUserName()) {
                        return $user;
                    }
                }

                throw new UserNotFoundException('User not found');
            }

            public function getByUuid(UUID $uuid): User
            {
                throw new UserNotFoundException('User not found');
            }
        };
    }

    public function testItReturnErrorResponseIdNoUsernameProvided(): void {
        $request = new Request([], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request username"}');
        $response->send();
    }

    public function testItReturnErrorResponseIdUserNotFound(): void {
        $request = new Request(['username'=>'Name'], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $response->send();
    }

    public function testItReturnSuccessfulResponse(): void{
        $request = new Request(['username'=>'Name'], [],'');
        $userRepository = $this->userRepository([new User(UUID::random(),new Name('Name','Lastname'),'admin')]);
        $action = new FindByUsername($userRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(SuccessResponse::class, $response);
        $this->expectOutputString('{"success":true,"data":{"username":"admin","name":"Name Lastname"}}');
        $response->send();
    }
}