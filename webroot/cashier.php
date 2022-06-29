<?php
require_once "../domain/services.php";

$services = ServiceRepository::get_all();
$service_for_customers = ServiceForCustomerRepository::get_all();

$car_types =
  [
    "Micro",
    "Sedan",
    "Hatchback",
    "Universal",
    "Liftback",
    "Coupe",
    "Cabriolet",
    "Roadster",
    "Targa",
    "Limousine",
    "Muscle Car",
    "Sport Car",
    "Super Car",
    "SUV",
    "Crossover",
    "Pickup",
    "Van",
    "Minivan",
    "Minibus",
    "Campervan",
  ];

$errors = [];

if (
  isset($_POST["customer_name"])
  && isset($_POST["car_type"])
  && isset($_POST["service_id"])
  && isset($_POST["charge"])
  && isset($_POST["cash"])
  && isset($_POST["tip"])
) {
  $service_id = $_POST["service_id"];
  $service = ServiceRepository::find_by_id($service_id);
  $service_name = $service->name;
  $customer_name = $_POST["customer_name"];
  $car_type = $_POST["car_type"];
  $charge = $service->fee;
  $cash = $_POST["cash"];
  $tip = $_POST["tip"];

  $change = $cash - ($charge + $tip);

  if ($change < 0) {
    $errors[] = "You don't have enough cash for this transaction";
  } else {
    ServiceForCustomerRepository::insert(
      $service_name,
      $customer_name,
      $car_type,
      $cash,
      $charge,
      $tip
    );
    header("Location: /cashier.php");
    exit();
  }
}
$initial_service_fee = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cashier</title>
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
  <?php if (count($services) > 0) { ?>
    <form method="post">
      <h2>CASHIER</h2>
      <label>Customer<input type="text" name="customer_name"
                            value="<?php echo $customer_name ?? "" ?>"
                            required/></label>
      <label>Car Type<input type="text" name="car_type"
                            list="car-type-data"
                            value="<?php echo $car_type ?? "" ?>"
                            required/></label>
      <datalist id="car-type-data">
        <?php foreach ($car_types as $car_type) { ?>
          <option value="<?php echo $car_type ?>"></option>
        <?php } ?>
      </datalist>
      <label>Services
        <select id="service-id-select" name="service_id" required>
          <?php foreach ($services as $service) { ?>
            <option value="<?php echo $service->id ?>">
              <?php
              if ($initial_service_fee === null) {
                $initial_service_fee =
                  $service->fee;
              }
              echo "$service->name - PHP $service->fee"
              ?>
            </option>
          <?php } ?>
        </select>
      </label>
      <label>
        Charge (PHP)
        <input id="charge-input-field" type="number" name="charge"
               value="<?php echo $initial_service_fee ?>" readonly required/>
      </label>
      <label>
        Cash (PHP)
        <input type="number" name="cash" value="<?php echo $cash ?? "" ?>"
               required/>
      </label>
      <label>
        Tip (PHP)
        <input type="number" name="tip" value="<?php echo $tip ?? "" ?>"
               required/>
      </label>
      <button>save</button>
      <div>
        <?php foreach ($errors as $error) { ?>
          <p><?php echo $error ?></p>
        <?php } ?>
      </div>
    </form>
  <?php } else { ?>
    <div class="card"><p>There are no services found, create services first
        <a href="services.php">here</a></p></div>
  <?php } ?>
  <div class="card">

    <?php if (count($service_for_customers) > 0) { ?>
      <table>
        <thead>
        <tr>
          <th>ID</th>
          <th>Service</th>
          <th>Customer Name</th>
          <th>Car Type</th>
          <th>Charge</th>
          <th>Tip</th>
          <th>Total</th>
          <th>Cash</th>
          <th>Change</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($service_for_customers as $sfc) { ?>
          <tr>
            <td><?php echo $sfc->id ?></td>
            <td><?php echo $sfc->service ?></td>
            <td><?php echo $sfc->customer_name ?></td>
            <td><?php echo $sfc->car_type ?></td>
            <td><?php echo $sfc->charge ?></td>
            <td><?php echo $sfc->tip ?></td>
            <td><?php echo($sfc->tip + $sfc->charge) ?></td>
            <td><?php echo $sfc->cash ?></td>
            <td><?php echo($sfc->cash - ($sfc->tip + $sfc->charge)) ?></td>
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
<script>
  const serviceIdToChargeMap = {
    <?php foreach ($services as $service) {?>
    [<?php echo $service->id ?>]: <?php echo $service->fee ?>,
    <?php } ?>
  }
  /**
   * @type {HTMLSelectElement}
   */
  const serviceIdSelect = document.querySelector("#service-id-select");

  /**
   * @type {HTMLInputElement}
   */
  const chargeInputField = document.querySelector("#charge-input-field");

  serviceIdSelect.addEventListener("change", (event) => {
    chargeInputField.value = serviceIdToChargeMap[event.target.value];
  });
</script>

<script src="js/trigger-anchor-on-click.js"></script>
</body>
</html>