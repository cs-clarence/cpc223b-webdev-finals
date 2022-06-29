<?php
require "connection.php";
$migrations_dir = __DIR__ . "/migrations";

if (!file_exists($migrations_dir)) {
  echo "No migrations to apply", PHP_EOL;
  return;
}

$migrations = scandir($migrations_dir, sorting_order: SCANDIR_SORT_ASCENDING);
$migrations = array_slice($migrations, 2);

if (count($migrations) === 0) {
  echo "Migrations folder is empty, no migrations to apply", PHP_EOL;
  return;
}

function table_exists(string $table_name): bool {
  $statement = Connection::get()->prepare("SELECT 1 FROM $table_name LIMIT 1");
  try {
    $statement->execute();
    return true;
  } catch (PDOException) {
    return false;
  }
}

$APPLIED_MIGRATIONS_TABLE_NAME = "__applied_migrations__";

if (!table_exists($APPLIED_MIGRATIONS_TABLE_NAME)) {
  $create_migration_table_sql = <<< SQL
  CREATE TABLE {$APPLIED_MIGRATIONS_TABLE_NAME} (
      id BIGINT PRIMARY KEY AUTO_INCREMENT,
      name VARCHAR(256) UNIQUE NOT NULL,
      hash VARCHAR(256) NOT NULL,
      applied_sql TEXT NOT NULL
  );
  SQL;

  $statement = Connection::get()->prepare($create_migration_table_sql);
  $statement->execute();
}

$statement = Connection::get()->prepare("SELECT id, name FROM {$APPLIED_MIGRATIONS_TABLE_NAME};");
$statement->execute();
$applied_migrations = $statement->fetchAll();

// Remove applied migrations
if ($applied_migrations !== false) {
  foreach ($applied_migrations as &$applied_migration) {
    $migration_name = $applied_migration["name"];

    if (($key = array_search($migration_name, $migrations)) !== false) {
      unset($migrations[$key]);
    }
  }
}

if (count($migrations) === 0) {
  echo "All migrations are already applied", PHP_EOL;
  return;
}

foreach ($migrations as &$migration) {
  $mig_dir = "{$migrations_dir}/{$migration}";
  $up = require "{$mig_dir}/up.php";
  echo "Applying migration: ", $migration, PHP_EOL;

  try {
    $statement = Connection::get()->prepare($up);
    $success = $statement->execute();
  } catch (PDOException $ex) {
    echo "Encountered an error when applying {$migration}: ", $ex->getMessage(), PHP_EOL;
    $success = false;
  }

  if ($success) {
    $sql_hash = hash("sha256", $up);
    $statement = Connection::get()->prepare(<<< SQL
        INSERT INTO {$APPLIED_MIGRATIONS_TABLE_NAME} (name, hash, applied_sql) VALUES(?, ?, ?); 
    SQL);
    $statement->execute([$migration, $sql_hash, $up]);
    echo "Successfully applied migration: ", $migration, PHP_EOL;
  } else {
    echo "Migration failed: ", $migration, PHP_EOL;
    break;
  }
}