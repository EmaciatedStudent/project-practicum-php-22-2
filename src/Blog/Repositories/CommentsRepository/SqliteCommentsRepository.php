<?php

namespace Tgu\Laperdina\Blog\Repositories\CommentsRepository;

use PDO;
use PDOStatement;
use Tgu\Laperdina\Blog\Comment;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\CommentNotFoundException;
use Psr\Log\LoggerInterface;

class SqliteCommentsRepository implements CommentsRepositoryInterface {
    private PDO $connection;
    private LoggerInterface $logger;

    public function __construct($connection, $logger) {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function saveComment(Comment $comment): void {
        $this->logger->info('Save comment');
        $statement = $this->connection->prepare(
            "INSERT INTO comment (id, id_post, id_author, text) VALUES (:id,:id_post,:id_author, :text)"
        );
        $statement->execute([
            ':id'=>(string)$comment->getUuidComment(),
            ':id_post'=>$comment->getUuidPost(),
            ':id_author'=>$comment->getUuidUser(),
            ':text'=>$comment->getTextComment()]
        );
        $this->logger->info("Save comment: $comment");
    }

    private function getComment(PDOStatement $statement, string $value): Comments {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result===false) {
            $this->logger->warning("Cannot get comment: $value");
            throw new CommentNotFoundException("Cannot get comment: $value");
        }

        return new Comments(new UUID(
            $result['id']),
            $result['id_post'],
            $result['id_author'],
            $result['text']
        );
    }

    public function getByUuidComment(UUID $id): Comment {
        $statement = $this->connection->prepare(
            "SELECT * FROM comments WHERE id = :id"
        );
        $statement->execute([':uuid_comment'=>(string)$id]);

        return $this->getComment($statement, (string)$id);
    }

    public function getTextComment(string $text): Comment {
        $statement = $this->connection->prepare(
            "SELECT * FROM comments WHERE text = :text"
        );
        $statement->execute([':text'=>(string)$text]);

        return $this->getComment($statement, $text);
    }
}