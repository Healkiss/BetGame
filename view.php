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
		echo 'Date d\'inscription : ' . date('d/m/Y \à H\:i', strtotime($user->RegistrationDate));
	}
}

function displayContestProfile($database, $id)
{
	$contests = $database->pdoExecute("SELECT * FROM contest WHERE idCONTEST=:id", array(':id' => $id));
	foreach ($contests as $contest)
	{
		echo 'Nom : ' . $contest->Name . '<br />';
		echo 'Prix : ' . $contest->Price . '<br />';
		echo 'Commencé le ' . date('d/m/Y \à H\:i', strtotime($contest->Startdate)) . '<br />';
		echo 'Lieu : ' . $contest->Location . '<br />';
		if ($contest->Enddate != 0)
		{
			echo 'Finie le : ' . date('d/m/Y \à H\:i', strtotime($contest->Enddate)) . '<br />';
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
	echo "<h3><a href='view.php?view=contestProfile&id=".$matches[0]->idCONTEST."'>" . $matches[0]->contestName . '</a> - ' . $matches[0]->Description . '</h3>';
	echo 'Débute le ' . date('d/m/Y \à H\:i', strtotime($matches[0]->Startdate)) . '<br />';
	echo 'Termine le ' . date('d/m/Y \à H\:i', strtotime($matches[0]->Enddate)) . '<br />';
	$sqlRequest = "SELECT *
		FROM match_gamer AS mg
		INNER JOIN gamer AS g ON g.idGAMER = mg.GAMER_idGAMER
		WHERE mg.MATCH_idMATCH=:id
		ORDER BY mg.Side";
	$competitors = $database->pdoExecute($sqlRequest, array(':id' => $id));
	//print_r($competitors);
	echo '
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Equipe</th>
					<th>Composition</th>
					<th>Score</th>
				</tr>
			</thead>
			<tbody>';
			$first = true;
			$oldSide = -1;			
				if ($competitors)	
				{
					foreach ($competitors as $competitor)
					{
						echo "<tr>";
							//if ($oldSide != $competitor->Side){
								$sqlRequest = "SELECT s.Score
								FROM `match` AS m
								INNER JOIN match_score AS ms ON m.idMATCH = ms.MATCH_idMATCH
								INNER JOIN `score` AS s ON s.idSCORE = ms.SCORE_idSCORE
								WHERE ms.MATCH_idMATCH=:idMatch
								AND ms.Side = :Side";
								$score = $database->pdoExecute($sqlRequest, array(':idMatch' => $id, ':Side' => $competitor->Side));
								
								$scoreTeam = $score[0]->Score?$score[0]->Score:"NC";
								echo "<td>" . $competitor->Side. "</td>";
								echo "<td><a href='view.php?view=gamerProfile&id=".$competitor->idGAMER."'>".$competitor->Name."</a></td>";
								echo "<td>" . $scoreTeam. "</td>";
								/*if ($first){
									echo "<tr>";
								}
								if (!$first){
									echo "</tr>";
									echo "<tr>";
								}*/
								$oldSide = $competitor->Side;
								$first = false;
						echo "</tr>";
							//}
						
					}
				}
				?>
			</tbody>
			<?php
	echo "</table>";
}

function displayGamerProfile($database, $id)
{
	$gamers = $database->pdoExecute("
SELECT gamer.idGAMER, gamer.Name, gamer.Birthdate , gamer.Description , country.nameFR countryName , videogame.idVIDEOGAME , videogame.Name gamevideoName
FROM `gamer`
LEFT JOIN `country` USING(idCOUNTRY)
LEFT JOIN `gamer_videogame` gv ON idGamer = GAMER_idGAMER
LEFT JOIN `videogame` ON idVIDEOGAME = gv.VIDEOGAME_idVIDEOGAME
WHERE idGAMER=:id", array(':id' => $id));
	?>
	<h3><?php echo $gamers[0]->Name ?></h3>
	Date de naissance : <?php echo date('d/m/Y', strtotime($gamers[0]->Birthdate)) ?><br/>
	Description : <?php echo $gamers[0]->Description ?><br/>
	Pays : <?php echo $gamers[0]->countryName ?><br/>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Jeux vidéos :</th>
			</tr>
		</thead>
		<?php
		foreach ($gamers as $videogame)
		{
			?>
			<tbody>
				<tr>
					<td><a href="view.php?view=videogameProfile&id=<?php echo $videogame->idVIDEOGAME ?>"><?php echo $videogame->gamevideoName ?></a></td>
				</tr>
			</tbody>
			<?php
		}
		?>
	</table>
	<?php
}

include("Footer.php");
?>