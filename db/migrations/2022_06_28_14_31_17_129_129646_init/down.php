<?php
$down_sql = <<< SQL
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS service_for_customer;
DROP TABLE IF EXISTS initial;
SQL;

return $down_sql;