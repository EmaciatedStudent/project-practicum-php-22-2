<?php

namespace Tgu\Laperdina\PhpUnit\Repositories\CommentsRepository;

use http\Exception\InvalidArgumentException;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Laperdina\Blog\Comment;
use Tgu\Laperdina\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\CommentNotFoundException;
use Tgu\Laperdina\PhpUnit\Blog\DummyLogger;

class SqliteCommentsRepositoryTest extends TestCase {
    public function testItTrowsAnExceptionWhenCommentNotFound(): void {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub);

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment: qwerty');

        $repository->getTextComment('qwerty');
    }

    public function testItSaveCommentsToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':id' =>'f165d492-bffe-448f-a499-b72d16a40f1b',
                ':id_post'=>'edb10650-3b52-4a8e-b05c-c5a1f167bed0',
                ':id_author'=>'f76cfc25-f8b2-4d15-9775-944db6648a82',
                ':text'=>'qwerty'
            ]);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $repository->saveComment( new Comment(
            new UUID('f165d492-bffe-448f-a499-b72d16a40f1b'),
            'edb10650-3b52-4a8e-b05c-c5a1f167bed0',
            'f76cfc25-f8b2-4d15-9775-944db6648a82',
            'qwerty'
        ));
    }

    public function testItUUidComments():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);


        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment:f165d492-bffe-448f-a499-b72d16a40f1b');

        $repository->getByUuidComment('f165d492-bffe-448f-a499-b72d16a40f1b');
    }
}