<?php
require_once "../domain/user_service.php";
session_start();
$email = "";
$password = "";

if (isset($_POST["email"]))
  $email = $_POST["email"];

if (isset($_POST["password"]))
  $password = $_POST["password"];

$errors = [];

if ($email !== "" && $password !== "") {
  $user = UserService::get()->login($email, $password);

  if ($user) {
    $_SESSION["user_id"] = $user->id;
    header("Location: /index.php");
    return;
  } else {
    $errors[] = "Invalid credentials";
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
  <h1>LOGIN WITH YOUR ACCOUNT</h1>
  <label>
    E-mail
    <input type="email" name="email" value="<?php echo $email ?>" required/>
  </label>
  <label>
    Password
    <input type="password" name="password" value="<?php echo $password ?>" minlength="8"
           required/>
  </label>
  <button>login</button>
</form>
<div>
  <?php foreach ($errors as $error) { ?>
    <p><?php echo $error ?></p>
  <?php } ?>
</div>
<div>
  <p>Don't have an account? <a href="register.php">Register</a></p>
</div>
</body>
</html>
