<?php
session_start();
echo $_SESSION['columns'];

$connect = mysqli_connect("127.0.0.1", "athrv", "ppnana1234", "practice_schema");
if(isset($_POST["first_name"], $_POST["last_name"]))
{
 $first_name = mysqli_real_escape_string($connect, $_POST["first_name"]);
 $last_name = mysqli_real_escape_string($connect, $_POST["last_name"]);
 $query = "INSERT INTO table1 (FirstName, LastName) VALUES('$first_name', '$last_name')";
echo $query;
 if(mysqli_query($connect, $query))
 {
  echo 'Data Inserted';
 }
}
?>
