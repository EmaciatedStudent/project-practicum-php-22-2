<?php

namespace Tgu\Laperdina\PhpUnit\Repositories\UserRepository;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Laperdina\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\InvalidArgumentExceptions;
use Tgu\Laperdina\Exceptions\UserNotFoundException;
use Tgu\Laperdina\Person\Name;
use Tgu\Laperdina\PhpUnit\Blog\DummyLogger;

class SqliteUsersRepositoryTest extends TestCase {
    public function testItTrowsAnExceptionWhenUserNotFound(): void {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Cannot get user: admin');

        $repository->getByUsername('admin');
    }

    public function testItSaveUserToDB(): void {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub->expects($this->once())
            ->method('execute')
            ->with([
                ':first_name'=>'Name',
                ':last_name'=>'LastName',
                ':uuid' =>'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3',
                ':username'=>'admin'
            ]);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub, new DummyLogger());

        $repository->save(new User(
            new UUID('cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3'),
            new Name('Name', 'LastName'),
            'admin'
        ));
    }

    /**
     * @throws UserNotFoundException
     */
    public function testItUUidUser (): User {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub, new DummyLogger());
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage(' UUID: cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3');

        $repository->getByUuid('cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3');
    }
}