<?php
require_once "../domain/services.php";

$initials = InitialRepository::get_all();
$errors = [];
$edit_id = null;

if (isset($_GET["edit"])) {
  $edit_id = $_GET["edit"];
  $initial = InitialRepository::find_by_id($edit_id);
  $date = $initial->date;
  $cash = $initial->cash;
}

if (isset($_POST["date"]) && isset($_POST["cash"])) {
  $date = $_POST["date"];
  $cash = $_POST["cash"];

  if ($edit_id !== null) {
    if ($initial->date === $date || !InitialRepository::is_date_used($date)) {
      InitialRepository::update($edit_id, $cash, $date);
      header("Location: /initial.php");
      exit();
    } else {
      $errors[] = "Date is already used, you can only set the date to the original date or one that isn't already used.";
    }

  } else {
    if (InitialRepository::is_date_used($date)) {
      $errors[] = "Date is already used, pick another one";
    } else {
      InitialRepository::insert($cash, $date);

      header("Location: /initial.php");
      exit();
    }
  }
}

if (isset($_GET["delete"])) {
  $delete_id = $_GET["delete"];

  InitialRepository::delete_by_id($delete_id);

  header("Location: /initial.php");
  exit();
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
    <h2>
      <?php if (isset($edit_id)) { ?>
        EDIT INITIAL <?php echo $edit_id ?>
      <?php } else { ?>
        CREATE INITIAL
      <?php } ?>
    </h2>
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
          <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($initials as $initial) { ?>
          <tr>
            <td><?php echo $initial->id ?></td>
            <td><?php echo $initial->date ?></td>
            <td><?php echo "PHP $initial->cash" ?></td>
            <td><a href="?edit=<?php echo "$initial->id" ?>">EDIT</a></td>
            <td><a href="?delete=<?php echo "$initial->id" ?>">DELETE</a></td>
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