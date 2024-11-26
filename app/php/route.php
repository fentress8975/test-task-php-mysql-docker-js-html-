<?php

namespace Products;

use Exception;

class Route
{
	static function start()
	{
        $controller = new CProducts();
		$action = "getWholeTable";
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if ( !empty($routes[1]) )
		{
			$action = $routes[1];
		}

        if(method_exists($controller, $action))
		{
			$controller->$action();
		}
		else
		{
			throw new Exception("wrong action");
		}

    }
}