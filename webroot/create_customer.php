<?php
require_once "../domain/customer_service.php";
require_once "../domain/user.php";

session_start();
$user_id = $_SESSION["user_id"];

$full_name = "";
$cash = 0.0;

if (isset($_POST["full_name"])) {
  $full_name = $_POST["full_name"];
}

if (isset($_POST["cash"])) {
  $cash = (float) $_POST["cash"];
}

if ($full_name !== "") {
  CustomerService::get()->create_for_user($user_id, $full_name, $cash);
  header("Location: /index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Customer Profile</title>
  <link rel="stylesheet" href="css/normalize.css">
  <style>
    form {
      display: flex;
      flex-direction: column;
    }
  </style>
</head>

<body>
<form method="post">
  <h1>CREATE YOUR CUSTOMER PROFILE</h1>
  <label>
    Full Name
    <input type="text" name="full_name" required/>
  </label>
  <label>
    Cash
    <input type="number" name="cash" required/>
  </label>
  <button>create</button>
</form>
</body>
</html>