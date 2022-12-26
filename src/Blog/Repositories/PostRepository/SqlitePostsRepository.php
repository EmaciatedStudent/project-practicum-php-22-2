<?php

namespace Tgu\Laperdina\Blog\Repositories\PostRepository;

use PDO;
use PDOStatement;
use Tgu\Laperdina\Blog\Post;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\PostNotFoundException;
use Psr\Log\LoggerInterface;

class SqlitePostsRepository implements PostsRepositoryInterface
{
    private PDO $connection;
    private LoggerInterface $logger;

    public function __construct($connection, $logger) {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function savePost(Post $post): void {
        $this->logger->info('Save post');
        $statement = $this->connection->prepare(
            "INSERT INTO post (uuid_post, uuid_author, title, text) VALUES (:uuid_post,    :uuid_author,:title, :text)"
        );
        $statement->execute([
            ':uuid_post'=>(string)$post->getUuidPost(),
            ':uuid_author'=>$post->getUuidUser(),
            ':title'=>$post->getTitle(),
            ':text'=>$post->getTextPost()]
        );
        $this->logger->info("Save post: $post" );
    }

    private function getPost(PDOStatement $statement, string $value): Post {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result===false){
            $this->logger->warning("Cannot get post: $value");
            throw new PostNotFoundException("Cannot get post: $value");
        }

        return new Post(new UUID(
            $result['uuid_post']),
            $result['uuid_author'],
            $result['title'],
            $result['text']
        );
    }

    public function getByUuidPost(UUID $uuidPost): Post
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM post WHERE uuid_post = :uuid_post"
        );
        $statement->execute([':uuid_post'=>(string)$uuidPost]);

        return $this->getPost($statement, (string)$uuidPost);
    }

    public function getTextPost(string $text):Post
    {
        $statement = $this->connection->prepare("SELECT * FROM post WHERE text = :text");
        $statement->execute([':text'=>(string)$text]);

        return $this->getPost($statement, $text);
    }
}