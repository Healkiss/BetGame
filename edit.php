<?php

include("Header.php");
include("Banniere.php");

/*
 * 
  Permet de modifier/ajouter des enregistrements
 */

switch ($_GET['view'])
{
	case 'contestEdit':
		displayContestProfile($conBdd, intval($_GET['id']));
		break;
	case 'videogameEdit':
		displayVideoGameProfile($conBdd, intval($_GET['id']));
		break;
	case 'matchEdit':
		displayMatchProfile($conBdd, intval($_GET['id']));
		break;
	default:
		header('HTTP/1.0 404 Not Found');
		break;
}