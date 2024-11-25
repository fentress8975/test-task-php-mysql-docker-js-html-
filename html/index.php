<?php

//phpinfo();

$host     = 'mysql';
$dbname   = 'test';
$user     = 'root';
$password = 'root';
$port     = 3306;
$charset  = 'utf8mb4';


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// $db = mysqli_connect($db, $user, $password);
$db = new mysqli($host, $user, $password, $dbname, $port);
$db->set_charset($charset);
$db->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
if (!$db) {
    die('Ошибка соединения: ' . mysqli_error($db));
}
echo 'Успешно соединились' . "<br>";

$result = $db->query("SELECT * FROM Products");
for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
    $result->data_seek($row_no);
    $row = $result->fetch_assoc();
    echo " id = " . $row['ID'] . " name =" .$row['PRODUCT_NAME'] . "<br>";
}
mysqli_close($db);