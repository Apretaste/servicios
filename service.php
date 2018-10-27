<?php

class Servicios extends Service
{
	/**
	 * Function executed when the service is called
	 *
	 * @param Request
	 * @return Response
	 */
	public function _main($request)
	{
		// get list of services
		$result = Connection::query("SELECT name, description, category FROM service WHERE listed = 1");

		// get the path to www
		$di = \Phalcon\DI\FactoryDefault::getDefault();
		$wwwroot = $di->get('path')['root'];
		$environment = $di->get('environment');

		// create array of arrays
		$services = [];
		$others = [];
		foreach($result as $res) {
			// get the image of the service
			$res->image = "$wwwroot/services/{$res->name}/{$res->name}.png";
			if( ! file_exists($res->image)) $res->image = "$wwwroot/public/images/noicon.png";

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
		$template = $environment=="web" ? "web.tpl" : "email.tpl";
		$responseContent = ["services" => $services, "serviceNum" => count($result)];

		// create response
		$response = new Response();
		$response->setEmailLayout("email_default.tpl");
		$response->setResponseSubject("Lista de servicios");
		$response->createFromTemplate($template, $responseContent);
		return $response;
	}
}
