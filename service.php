<?php

use Framework\Core;
use Apretaste\Request;
use Apretaste\Response;
use Framework\Database;

class Service
{
	/**
	 * Main function
	 *
	 * @param Request
	 * @param Response
	 * @author salvipascual
	 */
	public function _main(Request $request, Response $response)
	{
		// get list of services
		$services = Database::query("
			SELECT name, caption, category
			FROM service
			WHERE listed = 1
			AND active = 1
			ORDER BY name ASC");

		// get the image for the service
		$images = [];
		foreach ($services as $r) {
			$images[] = SERVICE_PATH . $r->name . "/" . $r->name . ".png";
		}

		// create the list of categories
		$categories = [];
		foreach ($services as $c) {
			if (isset($categories[$c->category])) {
				$categories[$c->category]->count++;
			} else {
				$category = new \stdClass();
				$category->code = $c->category;
				$category->name = Core::$serviceCategories[$c->category];
				$category->count = 1;
				$categories[$c->category] = $category;
			}
		}

		// sort the categories alphabetically
		ksort($categories);

		// create the content array
		$content = [
			"services" => $services,
			"categories" => $categories
		];

		// create response
		$response->setCache('month');
		$response->setTemplate("home.ejs", $content, $images);
	}
}
