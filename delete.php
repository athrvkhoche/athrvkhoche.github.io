<?php
$connect = mysqli_connect("127.0.0.1", "athrv", "ppnana1234", "practice_schema");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM table1 WHERE ID = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}
?>
