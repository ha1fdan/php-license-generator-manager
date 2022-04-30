<?php session_start();
require 'config.php'; 

if (isset($_SESSION['sess_authed']) && $_SESSION['sess_authed'] == "true") {
    #good
} else {
    header("Location: index.php");
}

$get_id=$_GET['id'];

require 'dbconn.php';
      
$sql = "DELETE FROM licenses WHERE id = ?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("i", $get_id);
if ($stmt->execute()) { 
    header("Location: dashboard.php?msg=Nøglen blev slettet med succes!");
} else {
    header("Location: dashboard.php?msg=Nøglen blev ikke slettet, der skete en fejl!");
}