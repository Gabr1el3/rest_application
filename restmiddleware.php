<?php
require_once("ospedaleLogic.php");

/*
URL endpoints:

[GET] ./restmiddleware.php -> GET all visits and appointments
[POST] ./restmiddleware.php -> POST a new appointment
*/

class RestService
{

	private $httpVersion = "HTTP/1.1";

	private function setHttpHeaders($contentType, $statusCode)
	{
		http_response_code($statusCode);
		header("Content-Type:" . $contentType);
		header("Access-Control-Allow-Origin: *");
	}

	public function encodeJson($responseData)
	{
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;
	}

	public function returnOk()
	{
		$this->setHttpHeaders("application/json", 200);
		echo "{\"result\": \"ok\"}";
	}

	public function returnKO($statusCode)
	{
		$this->setHttpHeaders("application/json", $statusCode);
		echo "{\"result\": \"ko\"}";
	}

	public function parseRequest()
	{
		try {
			$ospedale = new Ospedale();
			switch ($_SERVER['REQUEST_METHOD']) {
				case 'GET': {
						if ($_GET['action'] == "visite") {
							$result = $ospedale->getVisite();
						} elseif (isset($_GET['action']) && $_GET['action'] == "appuntamenti" && isset($_GET['id_tipo'])) {
							$result = $ospedale->getAppuntamento($_GET['id_tipo']);
						}
						$this->setHttpHeaders("application/json", 200);
						$jsonResponse = $this->encodeJson($result);
						echo $jsonResponse;
					}
					break;
				case 'POST': {
						$data = json_decode(file_get_contents('php://input'), true);
						if (array_key_exists("cognome", $data) && array_key_exists("nome", $data) && array_key_exists("eta", $data) && array_key_exists("sesso", $data) && array_key_exists("tipologia", $data) && array_key_exists("cognome_medico", $data) && array_key_exists("nome_medico", $data) && array_key_exists("date", $data)) {
							$result = $ospedale->createVisita($data);
							if ($result) {
								$this->returnOk();
							} else {
								$this->returnKO(400);
							}
						} else {
							$this->returnKO(400);
						}
					}
					break;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}

$restService = new RestService();
$restService->parseRequest();
