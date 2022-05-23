<?php
require_once("dbaccess.php");

class Ospedale
{

	private $db;

	public function getVisite()
	{
		$db = new DbAccess();
		$list = $db->select_visitaTipo();
		return $list;
	}

	public function getAppuntamento($id_tipo)
	{
		$db = new DbAccess();
		$list = $db->select_appuntamentoVisita($id_tipo);
		return $list;
	}

	public function createVisita($ospedale)
	{
		$db = new DbAccess();
		$list_utente = $db->select_utente($ospedale['cognome'], $ospedale['nome']);
		if (!$list_utente) {
			$result_utente = $db->create_utente($ospedale['cognome'], $ospedale['nome'], $ospedale['eta'], $ospedale['sesso']);
			$list_utente = $db->select_utente($ospedale['cognome'], $ospedale['nome']);
		}

		$list_visita = $db->select_visita($ospedale['tipologia'], $ospedale['cognome_medico'], $ospedale['nome_medico']);
		$result = $db->create_appuntamento($list_utente[0]['id_utente'], $list_visita[0]['id_visita'], $ospedale['date']);      /*array dentro array*/
		return $result;
	}
}

function debug($element)
{
	echo '<pre>' . var_dump($element) . '</pre>';
}
