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

    function getDefaultTable()
    {
        $data = $this->model->getDefaultModel();
        $this->view->generate('products_template_view.php', $data);
    }

    function getTable(string $sortRow = "PRODUCT_ID", string $sortRowOrder = "ASC", int $itemPerPage = 15, int $page = 1)
    {
        $data = $this->model->getModel($sortRow, $sortRowOrder, $itemPerPage, $page);
        $decode = json_encode($data, true);
        echo $decode;
    }

    function updateProductQuanity()
    {
        $postData = json_decode(file_get_contents('php://input'));

        $this->model->updateProductQuanity($postData->quanity, $postData->id);
    }

    function setProductDeletion()
    {
        $postData = json_decode(file_get_contents('php://input'));
        $this->model->setDelete($postData->id);
    }
}
