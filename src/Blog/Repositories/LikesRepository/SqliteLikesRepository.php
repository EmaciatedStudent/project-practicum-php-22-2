<?php

namespace Tgu\Laperdina\Blog\Repositories\LikesRepository;

use PDO;
use PDOStatement;
use Tgu\Laperdina\Blog\Likes;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\LikeNotFoundException;

class SqliteLikesRepository implements LikesRepositoryInterface {
    private PDO $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function saveLike(Likes $likes): void {
        $statement = $this->connection->prepare (
            "INSERT INTO likes (uuid_like, uuid_post, uuid_user) VALUES (:uuid_like,:uuid_post,:uuid_user)"
        );
        $statement->execute([
            ':uuid_comment'=>(string)$likes->getUuidLike(),
            ':uuid_post'=>$likes->getUuidPost(),
            ':uuid_author'=>$likes->getUuidUser()
        ]);
    }

    private function getLike(PDOStatement $statement, string $value): Likes {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result===false){
            throw new LikeNotFoundException("Cannot get like: $value");
        }

        return new Likes(new UUID($result['uuid_like']),
            $result['uuid_post'], $result['uuid_user']);
    }

    public function getByPostUuid(string $uuid_post): Likes {
        $statement = $this->connection->prepare (
            "SELECT * FROM likes WHERE uuid_post = :uuid_post"
        );
        $statement->execute([':uuid_post'=>$uuid_post]);

        return $this->getLike($statement, $uuid_post);
    }
}