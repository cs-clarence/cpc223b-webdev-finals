<?php
require_once "customer.php";
require_once "../db/connection.php";

class CustomerService {
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


  public function create_for_user(
    int $user_id,
    string $full_name,
    float $cash
  ): void {
    $stmt =
      $this->connection->prepare(
        "INSERT INTO customers(user_id, full_name, cash) VALUES(:user_id, :full_name, :cash)"
      );
    $stmt->execute(
      ["user_id" => $user_id, "full_name" => $full_name, "cash" => $cash]
    );
  }

  public function get_by_user_id(int $user_id): ?Customer {
    $stmt =
      $this->connection->prepare(
        "SELECT * FROM customers WHERE user_id = :user_id"
      );
    $stmt->execute(["user_id" => $user_id]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, Customer::class);
    $result = $stmt->fetch();
    if (!$result) return null;

    return $result;
  }

  public function get_all_users(): array {
    $stmt = $this->connection->prepare("SELECT * FROM customers");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, Customer::class);
    return $stmt->fetchAll(PDO::FETCH_CLASS);
  }

  public function update_customer(int $id, string $full_name, float $cash) {
    $this->connection->prepare(
      "UPDATE customers SET full_name = :full_name, cash = :cash WHERE id = :id"
    )->execute(["cash" => $cash, "id" => $id, "full_name" => $full_name]);
  }
}