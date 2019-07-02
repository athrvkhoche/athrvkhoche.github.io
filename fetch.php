<?php
//fetch.php

session_start();

$connect = mysqli_connect("127.0.0.1", "athrv", "ppnana1234");//, "practice_schema");

$tables = mysqli_fetch_row(mysqli_query($connect, "SHOW TABLES FROM practice_schema"));

$table =  $tables[0];

    //mysql_list_tables ( "practice_schema" [, resource $link_identifier = NULL ] ) : resource

if (!$connect) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$sql = "SELECT * FROM practice_schema.$table";
$result = mysqli_query($connect,$sql) or die(mysql_error());
for($i = 0; $i < mysqli_num_fields($result); $i++) {
    $field_info = mysqli_fetch_field($result);
    $columns[] = $field_info->name;
}

$_SESSION['columns'] = $columns;


//$columns = array('ID','FirstName', 'LastName');


$query = "SELECT * FROM practice_schema.$table ";

if(isset($_POST["search"]["value"]))
{
 $query .= 'WHERE '.$columns[1].' LIKE "%'.$_POST["search"]["value"].'%" ';
 for($i = 2; $i< count($columns); $i++){
     $query .= 'OR ';
     $query .= $columns[$i];
     $query .= ' LIKE "%'.$_POST["search"]["value"].'%" ';
 }
 //echo $query;
 
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].'
 ';
}
else
{
 $query .= 'ORDER BY id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);


$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["ID"].'" data-column="FirstName">' . $row["FirstName"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["ID"].'" data-column="LastName">' . $row["LastName"] . '</div>';
 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["ID"].'">Delete</button>';
 $data[] = $sub_array;
}

function get_all_data($connect, $table)
{
 $query = "SELECT * FROM practice_schema.$table ";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect, $table),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>
