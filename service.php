<?php

class Service
{
	/**
	 * Main function
	 *
	 * @author salvipascual
	 * @param Request
	 * @param Response
	 */
	public function _main(Request $request, Response $response)
	{
		// get list of services
		$result = Connection::query("SELECT name, description, category FROM service WHERE listed = 1");

		// get the path to www
		$di = \Phalcon\DI\FactoryDefault::getDefault();
		$wwwroot = $di->get('path')['root'];

		// create array of arrays
		$images = [];
		$services = [];
		$others = [];
		foreach($result as $res) {
			// get the image for the service
			$imgPath = "$wwwroot/services/{$res->name}/{$res->name}.png";
			if( ! file_exists($imgPath)) $imgPath = "$wwwroot/public/images/noicon.png";
			$res->image = basename($imgPath);

			// save image to the images array only once
			if( ! in_array($imgPath, $images)) $images[] = $imgPath;

			// to keep the categoty "others" at the end
			if($res->category == "otros") {
				$others[] = $res;
				continue;
			}

			// group all other categories in a big array
			if( ! isset($services[$res->category])) $services[$res->category] = [];
			array_push($services[$res->category], $res);
		}

		// sort by category alphabetically and merge to "other"
		ksort($services);
		$services = array_merge($services, ["otros"=>$others]);

		// get variables to send to the template
		$content = new stdClass();
		$content->services = $services;
		$content->serviceNum = count($result);

		// create response
		$response->setTemplate("home.ejs", $content, $images);
	}
}
