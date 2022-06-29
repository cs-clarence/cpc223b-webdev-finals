<?php
$up_sql = <<< SQL
CREATE TABLE services (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  service_name VARCHAR(255) NOT NULL,
  price DOUBLE NOT NULL
);

CREATE TABLE users (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(256) UNIQUE NOT NULL,
  password VARCHAR(256) NOT NULL,
  is_owner BOOL NOT NULL DEFAULT FALSE,
  is_cashier BOOL NOT NULL DEFAULT FALSE
);

CREATE TABLE customers (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT REFERENCES users(id),
  full_name TEXT NOT NULL,
  cash DOUBLE NOT NULL DEFAULT 0
);

CREATE TABLE services_for_customers (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  customer_id  BIGINT REFERENCES customers(id),
  service_id BIGINT REFERENCES services(id),
  date_posted DATE NOT NULL DEFAULT NOW(),
  time_posted DATE NOT NULL DEFAULT NOW()
);
SQL;

return $up_sql;