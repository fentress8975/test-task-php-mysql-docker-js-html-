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
echo 'Соединение успешно' . "<br>";


$result = $db->query("SELECT * FROM Products");
mysqli_close($db);
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>PRODUCT_ID</th>
            <th>PRODUCT_NAME</th>
            <th>PRODUCT_PRICE</th>
            <th>PRODUCT_ARTICLE</th>
            <th>PRODUCT_QUANTITY</th>
            <th>DATE_CREATE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
            $result->data_seek($row_no);
            $row = $result->fetch_assoc();
            echo "<tr>";
            echo "<td>" . $row['ID'] . "</td>";
            echo "<td>" . $row['PRODUCT_ID'] . "</td>";
            echo "<td>" . $row['PRODUCT_NAME'] . "</td>";
            echo "<td>" . $row['PRODUCT_PRICE'] . "</td>";
            echo "<td>" . $row['PRODUCT_ARTICLE'] . "</td>";
            echo "<td>" . $row['PRODUCT_QUANTITY'] . "</td>";
            echo "<td>" . $row['DATE_CREATE'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>