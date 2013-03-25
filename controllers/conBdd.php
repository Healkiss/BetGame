<?php

class conBDD
{

	public function __construct()
	{
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
		);
		try
		{
			$this->connexion = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::DB, self::USER, self::PASS, $options);
		}
		catch (Exception $e)
		{
			echo 'Erreur : ' . $e->getMessage() . '<br />';
			echo 'N° : ' . $e->getCode();
		}
	}
	
	public function pdoExecute($sqlRequest, $pdoArray = NULL, $select = true, $fetchMode = PDO::FETCH_OBJ)
	{
		$pdo = $this->connexion;
		$query = $pdo->prepare($sqlRequest);
		$success = $query->execute($pdoArray);
		if (!$success)
		{
			echo "Wrong request";
			print_r($pdo->errorInfo());
			$query->closeCursor();
			return ($select) ? null : false;
		}
		if ($select)
		{
			$data = $query->fetchAll($fetchMode);
			$query->closeCursor();
			return $data;
		}
		$query->closeCursor();
		return $success;
	}

	const HOST = "localhost";
	const USER = "root";
	const PASS = "";
	const DB = "betgame";

	public $connexion;
	private static $link;
	private static $instance = null;

}

?>