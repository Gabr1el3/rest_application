<?php

class DbAccess
{

	private function connect()
	{
		$servername = "127.0.0.1";
		$database = "ospedale";
		$username = "root";
		$password = "";
		$conn = mysqli_connect($servername, $username, $password, $database);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		return $conn;
	}

	private function close($conn)
	{
		mysqli_close($conn);
	}

	public function select_visitaTipo()
	{
		$sql = "SELECT id_tipo, cognome_medico, nome_medico, tipologia
              	FROM visita NATURAL JOIN tipo";
		$conn = $this->connect();
		$result = mysqli_query($conn, $sql);
		$list = array();
		while ($row = $result->fetch_assoc()) {
			$ospedale = [
				'id_tipo' => $row['id_tipo'],
				'cognome_medico' => $row['cognome_medico'],
				'nome_medico' => $row['nome_medico'],
				'tipologia' => $row['tipologia'],
			];
			$list[] = $ospedale;
		}
		$this->close($conn);
		return $list;
	}

	public function select_appuntamentoVisita($id_tipo)
	{
		$sql = "SELECT appuntamento.id_visita, appuntamento.date, visita.cognome_medico, visita.nome_medico, tipo.id_tipo, tipo.tipologia, utente.cognome, utente.nome 
	  			FROM appuntamento NATURAL JOIN visita NATURAL JOIN tipo NATURAL JOIN utente
				WHERE tipo.id_tipo=$id_tipo";
		$conn = $this->connect();
		$result = mysqli_query($conn, $sql);
		$list = array();
		while ($row = $result->fetch_assoc()) {
			$ospedale = [
				'id_visita' => $row['id_visita'],
				'cognome_medico' => $row['cognome_medico'],
				'nome_medico' => $row['nome_medico'],
				'tipologia' => $row['tipologia'],
				'date' => $row['date'],
				'id_tipo' => $row['id_tipo'],
				'cognome' => $row['cognome'],
				'nome' => $row['nome'],
			];
			$list[] = $ospedale;
		}
		$this->close($conn);
		return $list;
	}

	public function select_utente($cognome, $nome)
	{
		$sql = "SELECT id_utente
              	FROM utente
              	WHERE cognome='$cognome' AND nome='$nome'";
		$conn = $this->connect();
		$result = mysqli_query($conn, $sql);
		$list = array();
		if (mysqli_num_rows($result) > 0) {
			while ($row = $result->fetch_assoc()) {
				$ospedale = [
					'id_utente' => $row['id_utente'],
				];
				$list[] = $ospedale;
			}
			$this->close($conn);
			return $list;
		} else {
			$this->close($conn);
			return false;
		}
	}

	public function select_visita($tipologia, $cognome_medico, $nome_medico)
	{
		$sql = "SELECT id_visita
            	FROM visita NATURAL JOIN tipo
            	WHERE tipologia='$tipologia' AND cognome_medico='$cognome_medico' AND nome_medico='$nome_medico'";
		$conn = $this->connect();
		$result = mysqli_query($conn, $sql);
		$list = array();
		if (mysqli_num_rows($result) > 0) {
			while ($row = $result->fetch_assoc()) {
				$ospedale = [
					'id_visita' => $row['id_visita'],
				];
				$list[] = $ospedale;
			}
			$this->close($conn);
			return $list;
		} else {
			$this->close($conn);
			return false;
		}
	}

	public function select_tipo($tipologia)
	{
		$sql = "SELECT id_tipo
				FROM tipo
				WHERE tipologia='$tipologia'";
		$conn = $this->connect();
		$result = mysqli_query($conn, $sql);
		$list = array();
		while ($row = $result->fetch_assoc()) {
			$ospedale = [
				'id_tipo' => $row['id_tipo'],
			];
			$list[] = $ospedale;
		}
		$this->close($conn);
		return $list;
	}

	public function create_utente($cognome, $nome, $eta, $sesso)
	{
		$sql = "INSERT into utente (cognome, nome, eta, sesso) VALUES ('$cognome', '$nome', '$eta', '$sesso')";
		$conn = $this->connect();
		$result = mysqli_query($conn, $sql);
		$this->close($conn);
		return $result;
	}

	public function create_appuntamento($id_utente, $id_visita, $date)
	{
		$sqldate = date("Y-m-d", strtotime($date));
		$sql = "INSERT into appuntamento (id_utente, id_visita, date) VALUES ('$id_utente', '$id_visita', '$sqldate')";
		$conn = $this->connect();
		$result = mysqli_query($conn, $sql);
		$this->close($conn);
		return $result;
	}
}
