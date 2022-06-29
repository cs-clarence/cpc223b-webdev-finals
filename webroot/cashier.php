<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cashier</title>
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
  <label>Customer<input type="text" required/></label>
  <label>Car Type<input type="text" required/></label>
  <label>Services
    <select required>
      <option label="label1" selected>
        value1
      </option>
    </select>
  </label>
  <label>
    Charge (PHP)
    <input type="number" value="0" readonly required/>
  </label>
  <button>save</button>
</form>
</body>
</html>