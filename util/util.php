<?php
require_once "../domain/user.php";
require_once "../domain/customer_service.php";
require_once "../domain/user_service.php";

function establish_user() {
  session_start();
  if (!isset($_SESSION["user_id"])) {
    header("Location: /login.php");
    exit();
  }

  $user = UserService::get()->get_by_id((int) $_SESSION["user_id"]);

  if (!($customer = CustomerService::get()->get_by_user_id($user->id))) {
    header("Location: /create_customer.php");
    exit();
  }

  return [$user, $customer];
}