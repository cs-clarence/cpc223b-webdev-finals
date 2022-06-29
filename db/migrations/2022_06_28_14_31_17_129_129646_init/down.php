<?php
$down_sql = <<< SQL
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS services_for_customers;
SQL;

return $down_sql;