<?php
require 'config.php';

### Import the make_database.sql to your database

// Create connection
$conn = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_dbnavn);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}