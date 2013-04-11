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
	$sqlRequest = "
SELECT videogame.* , editor.Name editorName , studio.Name studioName , type.Name typeName , type.idTYPE
FROM videogame
LEFT JOIN `editor` USING(idEditor)
LEFT JOIN `studio` USING(idStudio)
LEFT JOIN `videogame_type` vt ON idVIDEOGAME = vt.VIDEOGAME_idVIDEOGAME
LEFT JOIN `type` ON idTYPE = TYPE_idTYPE
WHERE idVIDEOGAME=:id";
	$videoGames = $database->pdoExecute($sqlRequest, array(':id' => $id));
	echo 'Nom : ' . $videoGames[0]->Name . '<br />';
	echo 'Année de sortie : ' . $videoGames[0]->Year . '<br />';
	echo 'Studio : ' . $videoGames[0]->studioName . '</br/>';
	echo 'Éditeur : ' . $videoGames[0]->editorName . '</br/>';
	echo 'Type de jeu :';
	foreach ($videoGames as $videoGame)
		echo ' <a href="view.php?view=gameType&id="' . $videoGame->idTYPE . '>' . $videoGame->typeName . '</a>';
	echo '<br/>
		Description : <br/>
<p>' . $videoGames[0]->Description . '</p>';
}

function displayMatchProfile($database, $id)
{
	$sqlRequest = "
SELECT m.* , contest.Name contestName
FROM `match` m
LEFT JOIN contest USING(idCONTEST) 
WHERE idMATCH=:id";
	$matches = $database->pdoExecute($sqlRequest, array(':id' => $id));
	echo '<h3><a href="view.php?view=contestProfile&id="' . $matches[0]->idCONTEST . '>' . $matches[0]->contestName . '</a> - ' . $matches[0]->Description . '</h3>';
	echo 'Débute le ' . date('d/m/Y \à H\:i', strtotime($matches[0]->Startdate)) . '<br />';
	echo 'Termine le ' . date('d/m/Y \à H\:i', strtotime($matches[0]->Enddate)) . '<br />';
	echo '
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Joueurs</th>
				</tr>
			</thead>';
	$sqlRequest = "
SELECT * FROM match_gamer AS mg 
INNER JOIN gamer AS g ON g.idGAMER = mg.GAMER_idGAMER
WHERE mg.MATCH_idMATCH=:id";
	$competitors = $database->pdoExecute($sqlRequest, array(':id' => $id));
	foreach ($competitors as $competitor)
		echo "
			<tbody>
				<tr>
					<td><a href='view.php?view=userProfile&id=" . $competitor->idGAMER . "'>" . $competitor->Name . "</a></td>
				</tr>
			</tbody>";
	echo "</table>";
}

function displayGamerProfile($database, $id)
{
	$gamers = $database->pdoExecute("SELECT * FROM gamer WHERE idGAMER=:id", array(':id' => $id));
	foreach ($gamers as $gamer)
		echo 'Nom : ' . $gamer->Name . '<br />';
}

include("Footer.php");
?>