<?php

namespace Tgu\Laperdina\Blog\Repositories\UsersRepository;

use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\UserNotFoundException;
use Tgu\Laperdina\Person\Name;
use PDO;
use PDOStatement;
use Psr\Log\LoggerInterface;

class SqliteUsersRepository {
    private PDO $connection;
    private LoggerInterface $logger;

    public function __construct($connection, $logger) {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function save (User $user): void {
        $this->logger->info('Save user');
        $statement = $this->connection->prepare(
          "INSERT INTO users(uuid, first_name, last_name, user_name) VALUES (:uuid, :first_name, :last_name, :user_name)"
        );
        $statement->execute([
            ':uuid' => (string)$user->getByUuid(),
            ':first_name' => $user->getName()->getFirstName(),
            ':last_name' => $user->getName()->getLastName(),
            ':user_name' => $user->getUsername(),
        ]);
        $this->logger->info("Save user: $user" );
    }

    private function getUser(PDOStatement $statement, string $value): User {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result===false){
            $this->logger->warning("Cannot get user: $value");
            throw new UserNotFoundException("Cannot get user: $value");
        }

        return new User(new UUID($result['uuid']),
            new Name($result['first_name'], $result['last_name']),
            $result['username']);
    }

    public function getByUsername(string $username): User {
        $statement = $this->connection->prepare(
            "SELECT * FROM users WHERE username = :username"
        );
        $statement->execute([':username'=>(string)$username]);

        return $this->getUser($statement, $username);
    }

    public function getByUuid(UUID  $uuid): User {
        $statement = $this->connection->prepare(
            "SELECT * FROM users WHERE uuid = :uuid"
        );
        $statement->execute([':uuid'=>(string)$uuid]);

        return $this->getUser($statement, (string)$uuid);
    }
}