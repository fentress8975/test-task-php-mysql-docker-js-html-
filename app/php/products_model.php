<?php

namespace Products;

use mysqli;

class ProductsModel
{
    //proto
    public $host     = 'mysql';
    public $dbname   = 'test';
    public $user     = 'root';
    public $password = 'root';
    public $port     = 3306;
    public $charset  = 'utf8mb4';
    public $table = "Products";

    private $db;


    function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->db = new mysqli($this->host, $this->user, $this->password, $this->dbname, $this->port);
        $this->db->set_charset($this->charset);
        $this->db->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
    }

    private function getPageCount(int $itemsPerPage)
    {
        $sql = "SELECT COUNT(*) AS cnt FROM $this->table";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return ceil($result["cnt"] / $itemsPerPage);
    }

    private function getSortOrder(string $sortRowOrder = "ASC")
    {
        switch ($sortRowOrder) {
            case 'ASC':
                $sql_param = "ASC";
                break;
            case 'DESC':
                $sql_param = "DESC";
                break;
            default:
                $sql_param = "ASC";
                break;
        }
        return $sql_param;
    }

    private function getSortColumn(string $column)
    {
        $sql = "SELECT * FROM $this->table WHERE PRODUCT_DELETED = 0 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $columns = array_keys($result->fetch_assoc());

        if (in_array($column, $columns)) {
            return $column;
        } else {
            return $columns[0];
        }
    }

    private function prepareModel($stmt, int $page, int $itemPerPage)
    {
        $data["table"] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $data["pages"] = $this->getPageCount($itemPerPage);
        $data["offset"] = $page - 1;
        return $data;
    }

    public function getDefaultModel()
    {
        $itemsPerPage = 15;
        $sqlSortColumnParam = "ID";
        $sqlOrderParam = $this->getSortOrder();

        $sql = "SELECT * FROM $this->table WHERE PRODUCT_DELETED = 0 ORDER BY $sqlSortColumnParam ";
        $sql .= $sqlOrderParam;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $data["table"] = $result;
        $data["pages"] = $this->getPageCount($itemsPerPage);
        $data["itemsPerPages"] = $itemsPerPage;

        return $data;
    }

    public function getModel(string $sortColumn, string $sortColumnOrder, int $itemPerPage, int $page)
    {
        $sortColumnOrder = $this->getSortOrder($sortColumnOrder);
        $sortColumn = $this->getSortColumn($sortColumn);

        $sql = "SELECT * FROM $this->table WHERE PRODUCT_DELETED = 0 ORDER BY $sortColumn $sortColumnOrder  LIMIT ? OFFSET ?";

        $offset = ($page - 1) * $itemPerPage;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$itemPerPage, $offset]);

        $data = $this->prepareModel($stmt, $page, $itemPerPage);
        return $data;
    }

    public function updateProductQuanity(int $quanity, int $id)
    {
        $sql = "UPDATE $this->table SET PRODUCT_QUANTITY=PRODUCT_QUANTITY+? WHERE ID=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$quanity, $id]);
    }

    public function setDelete($id)
    {
        $sql = "UPDATE $this->table SET PRODUCT_DELETED=1 WHERE ID=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    function __destruct()
    {
        mysqli_close($this->db);
    }
}
