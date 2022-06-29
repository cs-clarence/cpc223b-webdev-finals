<?php
declare(strict_types=1);

final class Connection {
  private static PDO $connection;
  private static bool $is_initialized = false;

  public static function __constructStatic(): void {
    if (Connection::$is_initialized) return;

    Connection::$connection = new PDO(
      "mysql:host=127.0.0.1;dbname=carwash;port=3306",
      "root",
      "password"
    );

    Connection::$connection->setAttribute(
      PDO::ATTR_ERRMODE,
      PDO::ERRMODE_EXCEPTION
    );

    Connection::$connection->setAttribute(
      PDO::ATTR_DEFAULT_FETCH_MODE,
      PDO::FETCH_ASSOC
    );

    Connection::$is_initialized = true;

  }

  public static function get(): PDO {
    return Connection::$connection;
  }
}

Connection::__constructStatic();
