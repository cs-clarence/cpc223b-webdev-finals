<!DOCTYPE html>
<html lang="en">
<head>
  <title>Owner</title>
  <link rel="stylesheet" href="css/normalize.css">
  <style>
    form {
      display: flex;
      flex-direction: column;
    }
  </style>
</head>

<body>
<form>
  <div>
    <label>
      Date
      <input type="datetime-local" autofocus/>
    </label>
    <button>search</button>
  </div>
  <label>Total Number of Customer
    <input type="number" value="0" readonly/>
  </label>
  <label>Initial Cash
    <input type="number" value="0" readonly/>
  </label>
  <label>Total Expense Today
    <input type="number" value="0" readonly/>
  </label>
  <label>Income Earned Today
    <input type="number" value="0" readonly/>
  </label>
  <label>Total Income Earned Today
    <input type="number" value="0" readonly/>
  </label>
</form>
</body>
</html>