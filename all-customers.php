<?php

require_once "include/header.php";
require_once "include/connect.php";

$sql = "SELECT * FROM customers";
$result = mysqli_query($connection, $sql);

?>

<div class="conatiner d-flex justify-conetnt-center align-items-center m-3">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Current Balance</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>

      <?php
        while ($row = mysqli_fetch_assoc($result)) {
          ['id' => $id,
           'name' => $name,
            'email' => $email, 
            'current_balance' => $currentBalance] = $row;

            echo '<tr>
                    <th scope="row">' . $id . '</th>
                    <td>' . $name .  '</td>
                    <td>' . $email . '</td>
                    <td>' . $currentBalance . '</td>
                    <td><a class="btn btn-primary" href="customer.php?id=' . $id . '">Selet</a></td>
                  <tr>';
        }
      ?>

     
    </tbody>
  </table>
</div>


<?php
require_once "include/footer.php";
?>