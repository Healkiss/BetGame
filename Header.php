<?php
session_start();
include("controllers/conBdd.php");
include("controllers/dateFunctions.php");
global $conBdd, $connexion;
$conBdd = new conBDD();
$connexion = $conBdd->connexion;
?>
<!doctype html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="style/css/css.css" />
	</head>
	<body>

		<div class="container-fluid">