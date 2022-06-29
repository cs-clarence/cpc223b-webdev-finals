<?php
$down_sql = <<< SQL
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS service_for_customers;
DROP TABLE IF EXISTS initials;
SQL;

return $down_sql;