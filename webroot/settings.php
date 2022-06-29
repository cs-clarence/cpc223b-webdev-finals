<!DOCTYPE html>
<html lang="en">
<head>
  <title>Settings</title>
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
<h1>SETTINGS</h1>
<nav class="card">
  <ul>
    <li><a href="services.php" class="inherit-color">Services</a></li>
    <li><a href="initial.php" class="inherit-color">Initial</a></li>
  </ul>
</nav>
<button><a class="inherit-color" href="index.php">Home</a></button>
</body>

<script src="js/trigger-anchor-on-click.js"></script>
</html>
