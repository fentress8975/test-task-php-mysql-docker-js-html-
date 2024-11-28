<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Test task</title>
    <link rel="stylesheet" href="/css/simple.css">
    <script src="/js/products.js" type="text/javascript" defer></script>
</head>

<body>
    <main>
        <div><button onclick="productsTableHandler.getTable()">test get</button></div>
        <div id="itemsPerPage">Показывать на странице: <button class="active" onclick="productsTableHandler.setItemsPerPage(this)"> 15 </button> <button onclick="productsTableHandler.setItemsPerPage(this)"> 30 </button> <button onclick="productsTableHandler.setItemsPerPage(this)"> 50 </button></div>
        <div id="products_table">
            <table>
                <thead id="thead">
                    <tr>
                        <th class='sorted ASC'><button onclick="productsTableHandler.setSortColumn(this)">PRODUCT_ID</button></th>
                        <th><button onclick="productsTableHandler.setSortColumn(this)">PRODUCT_NAME</button></th>
                        <th><button onclick="productsTableHandler.setSortColumn(this)">PRODUCT_PRICE</button></th>
                        <th><button onclick="productsTableHandler.setSortColumn(this)">PRODUCT_ARTICLE</button></th>
                        <th><button onclick="productsTableHandler.setSortColumn(this)">PRODUCT_QUANTITY</button></th>
                        <th><button onclick="productsTableHandler.setSortColumn(this)">DATE_CREATE</button></th>
                        <th>Скрыть товар</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php
                    if (!mysqli_num_rows($data["table"])) {
                        echo "Таблица пуста";
                        die();
                    } else {
                        for ($row_no = 0; $row_no < $data["itemsPerPages"]; $row_no++) {
                            $data["table"]->data_seek($row_no);
                            $row = $data["table"]->fetch_assoc();
                            echo "<tr id=\"{$row['ID']}\">";
                            echo "<td>" . $row['PRODUCT_ID'] . "</td>";
                            echo "<td>" . $row['PRODUCT_NAME'] . "</td>";
                            echo "<td>" . $row['PRODUCT_PRICE'] . "</td>";
                            echo "<td>" . $row['PRODUCT_ARTICLE'] . "</td>";
                            echo "<td>" . "<button onclick=\"productsTableHandler.changeQuantity(this,-1)\">−</button> "  . $row['PRODUCT_QUANTITY'] . " <button onclick=\"productsTableHandler.changeQuantity(this,+1)\">+</button>" . "</td>";
                            echo "<td>" . $row['DATE_CREATE'] . "</td>";
                            echo "<td>" . "<button onclick=\"productsTableHandler.setDelete(this)\">×</button> " . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div id="paginate">
            <button onclick="productsTableHandler.turnPage(-1)">
                < </button>
                    <?php
                    for ($i = 1; $i < $data["pages"] + 1; $i++) {
                        echo "<button onclick=\"productsTableHandler.setPage($i)\"> $i </button>";
                    }
                    ?>
                    <button onclick="productsTableHandler.turnPage(+1)"> > </button>
        </div>
    </main>
</body>

</html>