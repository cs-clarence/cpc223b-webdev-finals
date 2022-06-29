<?php
require_once "../domain/user_service.php";
session_start();
$email = "";
$password = "";

if (isset($_POST["email"])) {
  $email = $_POST["email"];
}

if (isset($_POST["password"])) {
  $password = $_POST["password"];
}

$errors = [];
if ($email !== "" && $password !== "") {
  if (UserService::get()->is_email_used($email)) {
    $errors[] = "Email is already used";
  } else {
    if (UserService::get()->register($email, $password)) {
      $_SESSION["user_id"] = UserService::get()->login($email, $password)->id;
      header("Location: /create_customer.php");
      exit();
    } else {
      $errors[] = "Failed to create an account";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up</title>
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
  <h1>CREATE AN ACCOUNT</h1>
  <label>
    E-mail
    <input type="email" name="email" value="<?php echo $email ?>" required/>
  </label>
  <label>
    Password
    <input type="password" name="password" value="<?php echo $password ?>"
           minlength="8"
           required/>
  </label>
  <button>sign up</button>
</form>
<div>
  <?php foreach ($errors as $error) { ?>
    <p><?php echo $error ?></p>
  <?php } ?>
</div>
<div>
  <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
