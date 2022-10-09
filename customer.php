<?php
require_once "include/header.php";
require_once "include/connect.php";

// Get the id of the customer transfering from query string.
$id = $_GET['id'];


// Get the current customer data from database using id
$sql = "SELECT * FROM customers WHERE id = $id";
$currentCustomerResult = $connection->query($sql);
$currentCustomer = mysqli_fetch_assoc($currentCustomerResult);
$currentCustomerName = $currentCustomer['name'];

// Get all customers names and ids to show in the select option menu.
$sql = "SELECT id, name FROM customers";
$allCustomersResult = $connection->query($sql);

?>

<div class="conatiner m-3 p-3">
  <div class="d-flex flex-column jsutify-content-center align-items-center">
    <svg class="mb-4" xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
      <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
      <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
    </svg>
    <p>Account id: <strong><?php echo $currentCustomer['id']  ?></strong></p>
    <p>Customer Name: <strong><?php echo $currentCustomer['name'] ?></strong></p>
    <p>Email: <strong><?php echo $currentCustomer['email'] ?></strong></p>
    <p>Balance: <strong><?php echo $currentCustomer['current_balance'] ?></strong>
    <p>
  </div>
</div>

<div class="conatiner m-3 p-3">

  <form class="d-flex flex-column jsutify-content-center align-items-center" method="POST">
    <div class='mb-3'>
      <select class="form-select" name="transfer_to" required>
        <option value="-1" selected>Open this select menu</option>
        <?php

        while ($customer = mysqli_fetch_assoc($allCustomersResult)) {
          if ($customer['id'] !== $id) {
            echo '<option value="' . $customer['id'] . '">' . $customer['name'] . '</option>';
          }
        }

        ?>
      </select>
    </div>

    <div class="mb-3">
      <input type="number" name="amount" class="form-control" placeholder="Enter the amount of money" required>
    </div>

    <div class="mb-3">
      <button type="submit" name="transfer" class="btn btn-primary">Transfer</button>
    </div>
  </form>

</div>


<?php
require_once "include/footer.php";

// Submiting the form and tranfer the money
if (isset($_POST['transfer'])) {

  $to_customer = $_POST['transfer_to'];

  // if the user doesn't select a customer to transfer money to
  if ($to_customer === "-1") {
    echo "<script>Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please, Select a customer to transfer money to',
      })</script>";
    die;
  }

  $amount = $_POST['amount'];

  // if the amount of the money is greater than the sender balance
  if ($amount > $currentCustomer['current_balance']) {
    echo "<script>Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'The amount of money to transfer is greater than the current customer balance',
      })</script>";
    die;
  }

  $getCustomerTranferedTo = "SELECT * FROM customers WHERE id = $to_customer";
  $customer_to_name = mysqli_fetch_assoc($connection->query($getCustomerTranferedTo))['name'];

  $sqlCustomerTo = "UPDATE customers SET current_balance = current_balance + $amount Where id = $to_customer";
  $sqlCustomerFrom = "UPDATE customers SET current_balance = current_balance - $amount WHERE id = $id";
  $sqlAddTransfer = "INSERT INTO transfers (from_customer, to_customer, amount) VALUES ('$currentCustomerName', '$customer_to_name', $amount)";

  $result1 = $connection->query($sqlCustomerTo);
  $result2 = $connection->query($sqlCustomerFrom);
  $result3 = $connection->query($sqlAddTransfer);

  if ($result1 && $result2 && $result3) {
    echo "<script>Swal.fire({
        icon: 'success',
        title: 'Successful Transfer',
        text: 'The money is transfered successfully',
      })</script>";
    echo "<script>setTimeout(\"location.href = 'all-customers.php';\",1500);</script>";
  } else {
    echo "<script>Swal.fire({
        icon: 'error',
        title: 'Error in transfering...',
        text: 'The money isn't transfered successfully...',
      })</script>";
    echo "<script>setTimeout(\"location.href = 'all-customers.php';\",2000);</script>";
  }
}
?>