<?php
require_once "../db/connection.php";

class Service {
  public int $id;
  public string $name;
  public float $fee;
}

class ServiceForCustomer {
  public int $id;
  public string $service;
  public string $customer_name;
  public string $car_type;
  public float $cash;
  public float $charge;
  public float $tip;
  public string $date;
  public string $time;
}

final class ServiceRepository {
  private static PDO $connection;
  private static bool $is_initialized = false;

  public static function __constructStatic(): void {
    if (self::$is_initialized) return;

    self::$connection = Connection::get();
    self::$is_initialized = true;
  }

  public static function get_all(): array {
    $stmt = self::$connection->prepare("SELECT * FROM services");
    $stmt->setFetchMode(PDO::FETCH_CLASS, Service::class);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function find_by_id(int $id): ?Service {
    $stmt = self::$connection->prepare("SELECT * FROM services WHERE id = :id");
    $stmt->setFetchMode(PDO::FETCH_CLASS, Service::class);
    $stmt->execute(["id"=>$id]);
    $result = $stmt->fetch();

    if (!$result) return null;

    return $result;
  }

  public static function insert(string $name, float $fee): void {
    $stmt =
      self::$connection->prepare(
        "INSERT INTO services(name, fee) VALUE(:name, :fee)"
      );
    $stmt->setFetchMode(PDO::FETCH_CLASS, Service::class);
    $stmt->execute(["name" => $name, "fee" => $fee]);
  }

  public static function get_fee_for_id($id): float {
    $stmt =
      self::$connection->prepare(
        "SELECT fee FROM services WHERE id = :id;"
      );
    $stmt->execute(["id" => $id]);
    return $stmt->fetchColumn();
  }

  public static function delete(int $id) {
    $stmt =
      self::$connection->prepare(
        "DELETE FROM services WHERE id = :id"
      );
    $stmt->execute(["id" => $id]);
  }

  public static function update(int $id, string $name, float $fee) {
    $stmt =
      self::$connection->prepare(
        "UPDATE services SET name = :name, fee = :fee WHERE id = :id"
      );
    $stmt->execute(["id" => $id, "name" => $name, "fee" => $fee]);
  }
}

ServiceRepository::__constructStatic();

final class ServiceForCustomerRepository {
  private static PDO $connection;
  private static bool $is_initialized = false;

  public static function __constructStatic(): void {
    if (self::$is_initialized) return;

    self::$connection = Connection::get();
    self::$is_initialized = true;
  }

  public static function get_all(): array {
    $stmt = self::$connection->prepare("SELECT * FROM service_for_customers");
    $stmt->setFetchMode(PDO::FETCH_CLASS, ServiceForCustomer::class);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function insert(
    string $service,
    string $customer_name,
    string $car_type,
    float $cash,
    float $charge,
    float $tip
  ): void {
    $stmt =
      self::$connection->prepare(
        <<< SQL
        INSERT INTO service_for_customers(service, customer_name, car_type, 
                                         cash, charge, tip, date, time) 
            VALUE(:service, :customer_name, :car_type, :cash, :charge, 
                  :tip, :date, :time) 
      SQL
      );

    $date_time = new DateTime();

    $stmt->setFetchMode(PDO::FETCH_CLASS, ServiceForCustomer::class);
    $stmt->execute(
      [
        "service" => $service,
        "customer_name" => $customer_name,
        "cash" => $cash,
        "charge" => $charge,
        "car_type" => $car_type,
        "tip" => $tip,
        "date"=> $date_time->format("Y-m-d"),
        "time"=> $date_time->format("H-i-s"),
      ]
    );
  }

  public static function date_has_entry(string $date): bool {
    $stmt = self::$connection->prepare("SELECT COUNT(*) FROM service_for_customers WHERE date = :date");
    $stmt->execute(["date"=>$date]);
    return $stmt->fetchColumn() > 0;
  }

  public static function total_number_of_customer_for_date(string $date): int {
    $stmt = self::$connection->prepare("SELECT COUNT(customer_name) FROM service_for_customers WHERE date = :date");
    $stmt->execute(["date"=>$date]);
    return $stmt->fetchColumn();
  }

  public static function total_income_earned_for_date(string $date): float {
    $stmt = self::$connection->prepare("SELECT SUM(charge + tip) FROM service_for_customers WHERE date = :date");
    $stmt->execute(["date"=>$date]);
    return $stmt->fetchColumn();
  }

  public static function total_income_earned(): float {
    $stmt = self::$connection->prepare("SELECT SUM(charge + tip) FROM service_for_customers");
    $stmt->execute();
    return $stmt->fetchColumn();
  }
}

ServiceForCustomerRepository::__constructStatic();

class Initial {
  public int $id;
  public string $date;
  public float $cash;
}

class InitialRepository {
  private static PDO $connection;
  private static bool $is_initialized = false;

  public static function __constructStatic(): void {
    if (self::$is_initialized) return;

    self::$connection = Connection::get();
    self::$is_initialized = true;
  }

  public static function insert(float $cash, string $date): void {
    $stmt = self::$connection->prepare("INSERT INTO initials(date, cash) VALUES (:date, :cash)");
    $stmt->execute(["date"=>$date, "cash"=>$cash]);
  }

  public static function is_date_used(string $date): bool {
    return self::find_by_date($date) !== null;
  }

  public static function find_by_date(string $date): ?Initial {
    $stmt = self::$connection->prepare("SELECT * FROM initials WHERE date = :date");
    $stmt->setFetchMode(PDO::FETCH_CLASS, Initial::class);
    $stmt->execute(["date"=>$date]);
    $result = $stmt->fetch(PDO::FETCH_CLASS);

    if (!$result) return null;

    return $result;
  }

  /**
   * @return Initial[]
   */
  public static function get_all(): array {
    $stmt = self::$connection->prepare("SELECT * FROM initials;");
    $stmt->setFetchMode(PDO::FETCH_CLASS, Initial::class);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}

InitialRepository::__constructStatic();