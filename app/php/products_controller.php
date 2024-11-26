<?php

namespace Products;

class CProducts
{
    private $model;
    private $view;

    function __construct()
    {
        $this->model = new ProductsModel();
        $this->view = new ProductsView();
    }

    function getWholeTable()
    {
        //test
        $data = $this->model->getWholeTable();
        $this->view->generate('products_template_view.php', $data);
    }
}
