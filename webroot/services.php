<?php
require_once "../domain/services.php";

$name = "";
$fee = "";

$edit_id = null;
if (isset($_GET["edit"])) {
  $edit_id = $_GET["edit"];
  $service = ServiceRepository::find_by_id($edit_id);
  $name = $service->name;
  $fee = $service->fee;
}

if (isset($_GET["delete"])) {
  $delete_id = $_GET["delete"];
  ServiceRepository::delete($delete_id);
}

if (isset($_POST["name"]) && isset($_POST["fee"])) {
  $name = $_POST["name"];
  $fee = $_POST["fee"];

  if ($edit_id !== null) {
    ServiceRepository::update($edit_id, $name, $fee);
    header("Location: /services.php");
    exit();
  } else {
    ServiceRepository::insert($name, $fee);
  }
}

$services = ServiceRepository::get_all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Services</title>
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
        EDIT SERVICE <?php echo $edit_id ?>
      <?php } else { ?>
        CREATE SERVICE
      <?php } ?>
    </h2>
    <label>
      Name
      <input name="name" type="text" required value="<?php echo $name ?>">
    </label>
    <label>
      Fee
      <input name="fee" type="number" required value="<?php echo $fee ?>">
    </label>
    <button>save</button>
  </form>
  <div class="card">

  <?php if (count($services) > 0) { ?>
    <table>
      <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Fee</th>
        <th></th>
        <th></th>
      </tr>
      </thead>

      <tbody>
      <?php foreach ($services as $service) { ?>
        <tr>
          <td><?php echo $service->id ?></td>
          <td><?php echo $service->name ?></td>
          <td>PHP <?php echo $service->fee ?></td>
          <td><a href="?edit=<?php echo $service->id ?>">EDIT</a></td>
          <td><a href="?delete=<?php echo $service->id ?>">DELETE</a></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
      <p>No services found</p>
  <?php } ?>
  </div>

</main>
<button><a class="inherit-color" href="index.php">Home</a></button>
</body>

<script src="js/trigger-anchor-on-click.js"></script>
</html>
