<?php

namespace Products;

use Exception;

class Route
{
	static function start()
	{
		$controller = new CProducts();
		$action = "getDefaultTable";
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if (!empty($routes[1])) {
			$action = $routes[1];
		}

		if (method_exists($controller, $action)) {
			switch ($action) {
				case "getDefaultTable":
					$controller->$action();
					break;
				case 'getTable':
					$controller->$action(...$_GET);
					break;
				default:
					$controller->$action();
					break;
			}
		} else {
			throw new Exception("wrong action");
		}
	}
}
