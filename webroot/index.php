<!DOCTYPE html>
<html lang="en">
<head>
  <title>Carwash</title>
  <link rel="stylesheet" href="css/base.css">
  <style>
    ul {
      padding: 0;
      display: flex;
      flex-direction: column;
      gap: 16px;
      align-items: center;
    }
    ul > li {
      list-style: none;
      text-transform: uppercase;
      font-size: 1.5rem;
      font-weight: bold;
      background-color: transparent;
      border-radius: 16px;
      padding: 16px;
      transform: scale(100%);
      transition: transform 150ms ease-in-out, background-color 150ms ease-in-out;
    }

    ul > li:hover {
      background-color: var(--primary-color);
      transform: scale(115%);
    }
  </style>
</head>

<body>
<h1>CARWASH</h1>
<nav class="card">
  <ul>
    <li><a href="cashier.php" class="inherit-color">Cashier</a></li>
    <li><a href="owner.php" class="inherit-color">Owner</a></li>
    <li><a href="settings.php" class="inherit-color">Settings</a></li>
  </ul>
</nav>
</body>

<script src="js/trigger-anchor-on-click.js"></script>
</html>
