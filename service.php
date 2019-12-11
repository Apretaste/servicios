<?php

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
			SELECT name, category 
			FROM service 
			WHERE listed = 1
			ORDER BY name ASC");

		// get the image for the service
		$images = [];
		foreach ($services as $r) {
			$images[] = SERVICE_PATH . $r->name . "/" . $r->name . ".png";
			$r->name = ucfirst($r->name);
			$r->category = ucfirst($r->category);
		}

		// create the list of categories
		$categories = [];
		foreach ($services as $c) {
			if(!in_array($c->category, $categories)) $categories[] = $c->category;
		}

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