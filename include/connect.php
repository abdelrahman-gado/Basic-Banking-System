<?php

$connection =  new mysqli('localhost', 'root', 'G@edox23101997', 'banking_system');
if (!$connection) {
  die(mysqli_error($connection));
}