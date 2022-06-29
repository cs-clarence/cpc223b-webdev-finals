<?php
if ($argc != 2) {
  throw new Error("Invalid number of arguments, expected 1 for migration name");
}

$date_time = new DateTime();
$dt_string = $date_time->format("Y_m_d_H_i_s_v_u");

$folder_name = "{$dt_string}_{$argv[1]}";
$migrations_dir = __DIR__ . "/migrations";

if (!file_exists($migrations_dir)) {
  mkdir($migrations_dir);
}

$full_dir = "{$migrations_dir}/{$folder_name}";

mkdir($full_dir);

$up = <<< 'PHP'
<?php
$up_sql = <<< SQL

SQL;

return $up_sql;
PHP;

$down = <<< 'PHP'
<?php
$down_sql = <<< SQL

SQL;

return $down_sql;
PHP;

file_put_contents("{$full_dir}/up.php", $up);
file_put_contents("{$full_dir}/down.php", $down);
