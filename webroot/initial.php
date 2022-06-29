<?php
require_once "../domain/services.php";

$initials = InitialRepository::get_all();
$errors = [];
if (isset($_POST["date"]) && isset($_POST["cash"])) {
  $date = $_POST["date"];
  $cash = $_POST["cash"];

  if (InitialRepository::is_date_used($date)) {
    $errors[] = "Date is already used, pick another one";
  } else {
    InitialRepository::insert($cash, $date);
    header("Location: /initial.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Owner</title>
  <link rel="stylesheet" href="css/base.css">
  <style>
    main {
      display: flex;
      flex-direction: row;
      gap: 32px;
    }
  </style>
</head>

<body>
<main>
  <form method="post">
    <h2>CREATE INITIAL</h2>
    <label>
      Date
      <input type="date" name="date"
             value="<?php echo $date ?? date("Y-m-d") ?>"
             required/>
    </label>
    <label>
      CASH
      <input type="number" name="cash" value="<?php echo $cash ?? "" ?>"
             required/>
    </label>
    <button>save</button>
    <?php foreach ($errors as $error) { ?>
      <p><?php echo $error ?></p>
    <?php } ?>
  </form>

  <div class="card">
    <?php if (count($initials) > 0) { ?>
      <table>
        <thead>
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Cash</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($initials as $initial) { ?>
          <tr>
            <td><?php echo $initial->id ?></td>
            <td><?php echo $initial->date ?></td>
            <td><?php echo "PHP $initial->cash" ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>No records found.</p>
    <?php } ?>
  </div>
</main>

<button><a class="inherit-color" href="index.php">Home</a></button>
</body>

<script src="js/trigger-anchor-on-click.js"></script>
</html>