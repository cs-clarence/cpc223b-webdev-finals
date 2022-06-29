<?php
require_once "../domain/services.php";
$show_results = false;
$errors = [];

if (isset($_GET["date"])) {
  $date = $_GET["date"];

  if (ServiceForCustomerRepository::date_has_entry($date)) {
    $show_results = true;
    $initial_cash = InitialRepository::find_by_date($date)->cash;
    $number_of_customers =
      ServiceForCustomerRepository::total_number_of_customer_for_date($date);
    $income_earned =
      ServiceForCustomerRepository::total_income_earned_for_date($date);
    $total_income_earned =
      ServiceForCustomerRepository::total_income_earned($date);
    $initial_cash = InitialRepository::find_by_date($date)->cash;
  } else {
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