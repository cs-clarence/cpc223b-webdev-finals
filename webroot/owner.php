<?php
require_once "../domain/services.php";
$show_results = false;
$errors = [];

if (isset($_GET["date"])) {
  $date = $_GET["date"];

  $initial = InitialRepository::find_by_date($date);
  $has_entry = ServiceForCustomerRepository::date_has_entry($date);

  if ($has_entry) {
    $show_results = true;
    $number_of_customers =
      ServiceForCustomerRepository::total_number_of_customer_for_date($date);
    $income_earned =
      ServiceForCustomerRepository::total_income_earned_for_date($date);
    $total_income_earned =
      ServiceForCustomerRepository::total_income_earned($date);
  }

  if ($initial !== null) {
    $show_results = true;
    $initial_cash = $initial->cash;
  }

  if ($initial === null && !$has_entry) {
    $errors[] = "Date has no entry";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Owner</title>
  <link rel="stylesheet" href="css/base.css">
</head>

<body>
<form method="get">
  <h2>SEARCH DATE</h2>
  <label>
    Date
    <input type="date" name="date" value="<?php echo $date ?? date("Y-m-d") ?>"
           required/>
  </label>
  <button>search</button>
  <?php foreach ($errors as $error) { ?>
    <p><?php echo $error ?></p>
  <?php } ?>
  <?php if ($show_results) { ?>
    <label>Total Number of Customer
      <input type="number" value="<?php echo $number_of_customers ?? 0 ?>"
             readonly/>
    </label>
    <label>Initial Cash
      <input type="number" value="<?php echo $initial_cash ?? 0 ?>" readonly/>
    </label>
    <label>Total Expense Today
      <input type="number" value="0" readonly/>
    </label>
    <label>Income Earned Today
      <input type="number" value="<?php echo $income_earned ?? 0 ?>" readonly/>
    </label>
    <label>Total Income Earned
      <input type="number" value="<?php echo $total_income_earned ?? 0 ?>"
             readonly/>
    </label>
  <?php } ?>
</form>
<button><a class="inherit-color" href="index.php">Home</a></button>
</body>

<script src="js/trigger-anchor-on-click.js"></script>
</html>