<?php

namespace Products;

class ProductsView
{
    function generate($template_view, $data = null)
    {
        include $template_view;
    }
}
