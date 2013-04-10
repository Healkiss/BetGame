<?php

include("Header.php");
include("Banniere.php");

/*
 * 
  Resumé de chaque classe
  Visuel de chaque table
 */

switch ($_GET['view'])
{
	case 'userProfile':
		displayUserProfile($conBdd, intval($_GET['id']));
		break;
	case 'contestProfile':
		displayContestProfile($conBdd, intval($_GET['id']));
		break;
	case 'videogameProfile':
		displayVideoGameProfile($conBdd, intval($_GET['id']));
		break;
	case 'matchProfile':
		displayMatchProfile($conBdd, intval($_GET['id']));
		break;
	case 'gamerProfile':
		displayGamerProfile($conBdd, intval($_GET['id']));
		break;
	default:
		header('HTTP/1.0 404 Not Found');
		break;
}

function displayUserProfile($database, $id)
{
	$users = $database->pdoExecute("SELECT * FROM user WHERE idUSER=:id", array(':id' => $id));
	foreach ($users as $user)
	{
		echo 'Utilisateur : ' . $user->Nickname . '<br />';
		echo 'Nom complet : ' . $user->Name . '</br/>';
		echo 'Banque : ' . $user->Bank . '</br/>';
		echo 'Date d\'inscription : ' . getDateFormateeFromTimeStamp($user->RegistrationDate);
	}
}

function displayContestProfile($database, $id)
{
	$contests = $database->pdoExecute("SELECT * FROM contest WHERE idCONTEST=:id", array(':id' => $id));
	foreach ($contests as $contest)
	{
		echo 'Nom : ' . $contest->Name . '<br />';
		echo 'Prix : ' . $contest->Price . '<br />';
		echo 'Commencé le ' . getDateFormateeFromTimeStamp($contest->Startdate) . '<br />';
		echo 'Lieu : ' . $contest->Location . '<br />';
		if ($contest->Enddate != 0)
		{
			echo 'Finie le : ' . getDateFormateeFromTimeStamp($contest->Enddate) . '<br />';
		}
		else
		{
			echo 'En cours..<br />';
		}
	}
	echo "<a href='contest.php?id=" . $id . "'>Voir les participants à cette compétition.</a>";
}

function displayVideoGameProfile($database, $id)
{
	$videoGames = $database->pdoExecute("SELECT * FROM videoGame WHERE idVIDEOGAME=:id", array(':id' => $id));
	foreach ($videoGames as $videoGame)
	{
		echo 'Nom : ' . $videoGame->Name . '<br />';
		echo 'Studio : ' . $videoGame->Studio . '</br/>';
		echo 'Editeur : ' . $videoGame->Editor;
	}
}

function displayMatchProfile($database, $id)
{
	$matches = $database->pdoExecute("SELECT * FROM match WHERE idMATCH=:id", array(':id' => $id));
	foreach ($matches as $match)
	{
		echo 'Description : ' . $match->Name . '<br />';
		$sqlRequest = "
SELECT * FROM match_gamer AS mg 
INNER JOIN gamer AS g ON g.idGAMER = mg.GAMER_idGAMER
WHERE mg.MATCH_idMATCH=:id";
		$competitors = $database->pdoExecute($sqlRequest, array(':id' => $id));
		foreach ($competitors as $competitor)
			echo "\t<a href='view.php?view=userProfil&id=" . $competitor->idGAMER . "'>" . $competitor->Name . "</a><br/>";
	}
}

function displayGamerProfile($database, $id)
{
	$gamers = $database->pdoExecute("SELECT * FROM gamer WHERE idGAMER=:id", array(':id' => $id));
	foreach ($gamers as $gamer)
		echo 'Nom : ' . $gamer->Name . '<br />';
}

include("Footer.php");
?>