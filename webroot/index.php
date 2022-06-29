<?php
require_once "../util/util.php";

list($user, $customer) = establish_user();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Index</title>
  <link rel="stylesheet" href="css/normalize.css">
</head>

<body>
<nav>
  <p>Hello <?php echo $customer->full_name ?>!</p>
  <ul>
    <?php if ($user->is_cashier || $user->is_owner) { ?>
      <li><a href="cashier.php">Cashier</a></li>
    <?php } ?>
    <?php if ($user->is_owner) { ?>
      <li><a href="owner.php">Owner</a></li>
    <?php } ?>
    <li><a href="settings.php">Settings</a></li>
    <li><a href="services.php">Services</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</nav>
</body>
</html>
