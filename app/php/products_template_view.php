<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Test task</title>
    <link rel="stylesheet" href="/css/simple.css">
    <script src="/js/products.js" type="text/javascript"></script>
</head>

<body>
    <main>
        <div>Показывать на странице: <button onclick="setAmmountToDisplay(this)" > 15 </button> <button onclick="setAmmountToDisplay(this)"> 30 </button> <button onclick="setAmmountToDisplay(this)"> 50 </button></div>
        <table>
            <thead>
                <tr>
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
                for ($row_no = $data->num_rows - 1; $row_no >= 50; $row_no--) {
                    $data->data_seek($row_no);
                    $row = $data->fetch_assoc();
                    echo "<tr id=\"{$row['ID']}\">";
                    echo "<td>" . $row['PRODUCT_ID'] . "</td>";
                    
                    echo "<td>" . $row['PRODUCT_NAME'] . "</td>";
                    echo "<td>" . $row['PRODUCT_PRICE'] . "</td>";
                    echo "<td>" . $row['PRODUCT_ARTICLE'] . "</td>";
                    echo "<td>" . "<button onclick=\"reduceQuantity()\">-</button>"  . $row['PRODUCT_QUANTITY'] . "<button onclick=\"increaseQuantity()\">+</button>" . "</td>";
                    echo "<td>" . $row['DATE_CREATE'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div>
            <button onclick="pageBackward()"> < </button> 
            <button onclick="pageForward()"> > </button>
        </div>
    </main>
</body>
</html>