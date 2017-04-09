<?php
header('Content-Type: text/html; charset=utf-8');
$host="localhost";
$username="mghinfo_root";
$password="ER(a<sTQ6LbA(M-M";
$dbname = "mghinfo_blog";

$conn = new mysqli($host, $username, $password,$dbname);
mysqli_set_charset($conn,"utf8");

$sql = "SELECT * FROM foods";
$result = $conn->query($sql);
$foods = array();
$foods_1=array();
$foods_2=array();
while($row = $result->fetch_assoc()) 
{
  $foods[]=$row['foods'];
}

for($i=0;$i<14;$i++)
{
	$foods_1[]=$foods[$i];
}
for($i=14;$i<28;$i++)
{
	$foods_2[]=$foods[$i];
}

// $conn->close();
?>