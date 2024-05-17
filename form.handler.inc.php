<?php
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

if (!empty($email) && !empty($password)) {
  $host = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "project";

  // Create connection
  $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
  if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
  } else {
    $sql = "INSERT INTO registration (email, password) VALUES ('$email', '$password')";
    if ($conn->query($sql)) {
      echo "New record is inserted successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
  }
} else {
  echo "All fields are required for login.";
}
?>
