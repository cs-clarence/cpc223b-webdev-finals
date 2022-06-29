<?php
$up_sql = <<< SQL
CREATE TABLE services (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  fee DOUBLE NOT NULL
);

CREATE TABLE service_for_customers (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  customer_name TEXT NOT NULL,
  service TEXT NOT NULL,
  car_type TEXT NOT NULL,
  cash DOUBLE NOT NULL,
  charge DOUBLE NOT NULL,
  tip DOUBLE NOT NULL,
  date TEXT NOT NULL,
  time TEXT NOT NULL
);

CREATE TABLE initials (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  cash DOUBLE NOT NULL,
  date VARCHAR(32) UNIQUE NOT NULL 
);
SQL;

return $up_sql;