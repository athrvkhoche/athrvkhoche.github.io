<?php
$connect = mysqli_connect("127.0.0.1", "athrv", "ppnana1234", "practice_schema");
if(isset($_POST["id"]))
{
 $value = mysqli_real_escape_string($connect, $_POST["value"]);

 $query = "UPDATE table1 SET ".$_POST["column_name"]."='".$value."' WHERE ID =".$_POST["id"];
echo "$query";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Updated';
 }
}
?>
