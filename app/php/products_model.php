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

    private $db;

    function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->db = new mysqli($this->host, $this->user, $this->password, $this->dbname, $this->port);
        $this->db->set_charset($this->charset);
        $this->db->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
    }

    public function getWholeTable()
    {
        return $this->db->query("SELECT * FROM Products");
    }

    function __destruct()
    {
        mysqli_close($this->db);
    }
}
