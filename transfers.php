<?php

require_once "include/header.php";
require_once "include/connect.php";

$sql = "SELECT * FROM transfers";
$result = mysqli_query($connection, $sql);

?>

<div class="conatiner d-flex justify-conetnt-center align-items-center m-3">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">From</th>
        <th scope="col">To</th>
        <th scope="col">Amount</th>
        <th scope="col">Date & Time</th>
      </tr>
    </thead>
    <tbody>

      <?php
      while ($row = mysqli_fetch_assoc($result)) {
        [
          'id' => $id,
          'from_customer' => $from_customer,
          'to_customer' => $to_customer,
          'amount' => $amount,
          'issue_date' => $date
        ] = $row;

        echo '<tr>
                    <th scope="row">' . $id . '</th>
                    <td>' . $from_customer .  '</td>
                    <td>' . $to_customer . '</td>
                    <td>' . $amount . '</td>
                    <td>' . $date . '</td>
                  <tr>';
      }
      ?>


    </tbody>
  </table>
</div>


<?php
require_once "include/footer.php";
?>