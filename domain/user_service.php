<?php
require_once "../db/connection.php";
require_once "user.php";

class UserService {
  private static $instance;
  private static $is_initialized = false;

  public static function get(): self {
    if (!self::$is_initialized) {
      self::$instance = new self(Connection::get());
      self::$is_initialized = true;
    }

    return self::$instance;
  }

  private function __construct(private PDO $connection) {}

  public function register(string $email, string $password): bool {
    $stmt =
      $this->connection->prepare(
        "INSERT INTO users(email, password) VALUES(:email, :password);"
      );
    return $stmt->execute(["email" => $email, "password" => $password]);
  }

  public function login(string $email, string $password): ?User {
    $stmt =
      $this->connection->prepare("SELECT * FROM users WHERE email = :email;");
    $stmt->execute(["email" => $email]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
    $user = $stmt->fetch(PDO::FETCH_CLASS,);

    if (!$user) return null;

    return $user;
  }

  public function get_by_id(int $id): ?User {
    $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(["id" => $id]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
    $result = $stmt->fetch(PDO::FETCH_CLASS,);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  public function is_email_used(string $email): bool {
    $stmt =
      $this->connection->prepare(
        "SELECT COUNT(*) FROM users WHERE email = :email"
      );

    $stmt->execute(["email" => $email]);

    return $stmt->fetchColumn() > 0;
  }

  public function update_user(int $id, string $email, string $password) {
    $stmt =
      $this->connection->prepare(
        "UPDATE users SET email = :email, password = :password WHERE id = :id"
      );
    $stmt->execute(["id" => $id, "email" => $email, "password" => $password]);
  }
}