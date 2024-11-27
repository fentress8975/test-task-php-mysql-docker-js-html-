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

    public function getWholeTable(int $itemsPerPage = 15, string $sort = "ASC")
    {
        switch ($sort) {
            case 'ASC':
                $sql = "SELECT * FROM $this->table ORDER BY DATE_CREATE ASC";
                break;
            case 'DESC':
                $sql = "SELECT * FROM $this->table ORDER BY DATE_CREATE DESC";
                break;
            default:
                $sql = "SELECT * FROM $this->table ORDER BY DATE_CREATE ASC";
                break;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data["table"] = $stmt->get_result();
        $data ["pages"] = $this->getPageCount($itemsPerPage);
        $data ["itemsPerPages"] = $itemsPerPage;
        return $data;
    }

    public function getTable($ammount)
    {
        return $this->db->query("SELECT * FROM $this->table");
    }

    public function updateProductQuanity(int $quanity, int $id)
    {
        $sql = "UPDATE $this->table SET PRODUCT_QUANTITY=? WHERE ID=?";
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
