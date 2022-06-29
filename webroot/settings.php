<?php
require_once "../util/util.php";
require_once "../domain/user_service.php";
require_once "../domain/customer_service.php";

[$user, $customer] = establish_user();

$email = $user->email;
$password = $user->password;
$cash = $customer->cash;
$full_name = $customer->full_name;

$update_user = false;
$update_customer = false;
if (isset($_POST["update_user"])) {
  $update_user = $_POST["update_user"];
}

if (isset($_POST["update_customer"])) {
  $update_customer = $_POST["update_customer"];
}

$errors = [];
if ($update_user) {
  $email = null;
  $password = null;

  if (isset($_POST["email"])) {
    $email = $_POST["email"];
  } else {
    $errors[] = "Email can't be empty";
  }

  if (isset($_POST["password"])) {
    $password = $_POST["password"];
  } else {
    $errors[] = "Password can't be empty";
  }

  if ($email && $password) {
    UserService::get()->update_user($user->id, $email, $password);
  }
}

if ($update_customer) {
  $full_name = null;
  $cash = null;

  if (isset($_POST["full_name"])) {
    $full_name = $_POST["full_name"];
  } else {
    $errors[] = "Full Name can't be empty";
  }

  if (isset($_POST["cash"])) {
    $cash = $_POST["cash"];
  } else {
    $errors[] = "Cash can't empty";
  }

  if ($full_name && $cash) {
    CustomerService::get()->update_customer($customer->id, $full_name, $cash);
    header("Location: /settings.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Settings</title>
  <link rel="stylesheet" href="css/normalize.css">
</head>

<body>
<h1>SETTINGS</h1>
<form action="settings.php" method="post">
  <h2>User Information</h2>
  <input type="hidden" name="update_user" value="true"/>
  <label>
    E-mail
    <input type="email" name="email" value="<?php echo $email ?>"
           required/>
  </label>
  <label>
    Password
    <input type="password" name="password" value="<?php echo $password ?>"
           minlength="8"
           required/>
  </label>
  <button>update</button>
</form>
<form action="settings.php" method="post">
  <h2>Customer Information</h2>
  <input type="hidden" name="update_customer" value="true"/>
  <label>
    Full Name
    <input type="text" name="full_name"
           value="<?php echo $full_name ?>"
           required/>
  </label>
  <label>
    Cash
    <input type="number" name="cash" value="<?php echo $cash ?>"
           required/>
  </label>
  <button>update</button>
</form>
<a href="index.php">Home</a>
<div>
  <?php foreach ($errors as $error) { ?>
    <p><?php echo $error ?></p>
  <?php } ?>
</div>
</body>
</html>