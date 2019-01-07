<?php

class Service
{
	/**
	 * Function executed when the service is called
	 *
	 * @param Request
	 * @return Response
	 */
	public function _main($request, $response)
	{
		// get list of services
		$connection = new Connection();
		$result = $connection->query("SELECT name, description, category FROM service WHERE listed>0");

		// get the path to www
		$di = \Phalcon\DI\FactoryDefault::getDefault();
		$wwwroot = $di->get('path')['root'];

		// create array of arrays
		$services = array();
		$others = array();
		foreach($result as $res)
		{
			// get the image of the service
			$res->image = "$wwwroot/services/{$res->name}/{$res->name}.png";
			if( ! file_exists($res->image)) $res->image = "$wwwroot/public/images/noicon.png";
			Utils::parseImgDir($res->image, $request->environment);

			// to keep the categoty "others" at the end
			if($res->category == "otros")
			{
				$others[] = $res;
				continue;
			}

			// group all other categories in a big array
			if( ! isset($services[$res->category])) $services[$res->category] = array();
			array_push($services[$res->category], $res);
		}

		// sort by category alphabetically and merge to "other"
		ksort($services);
		$services = array_merge($services, array("otros"=>$others));

		// set response
		$response->setLayout("web_default.ejs");
		$response->setTemplate("web.ejs", ["services" => $services, "serviceNum" => count($result)]);
	}
}
