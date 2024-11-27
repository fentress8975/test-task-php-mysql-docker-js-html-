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
        $data = $this->model->getWholeTable();
        $this->view->generate('products_template_view.php', $data);
    }

    function getTable($ammount=15)
    {
        $data = $this->model->getTable($ammount);
        $this->view->generate('products_template_view.php', $data);
    }

    function updateProductQuanity(){
        $postData = json_decode(file_get_contents('php://input'));

        $this->model->updateProductQuanity($postData->quanity,$postData->id);
    }


}
