<?php
include("Header.php");
include("Banniere.php");

function shortString($string, $maxSize = 124)
{
	$string = strip_tags($string);
	if (strlen($string) > $maxSize)
	{
		$string = substr($string, 0, $maxSize);
		$string = substr($string, 0, strrpos($string, ' ')) . '…';
	}
	return $string;
}
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<div class="tabbable tabs-left">
				<ul class="nav nav-tabs">
					<li><a href="#gamers" data-toggle="tab">Joueurs</a></li>
					<li><a href="#users" data-toggle="tab">Utilisateurs</a></li>
				</ul>
			</div>
		</div>
		<div class="span10">
			<div id="gamers">
				<h2 class="text-center">Joueurs</h2>
				<?php
				$sqlRequest = "
SELECT gamer.idGAMER, gamer.Name, gamer.Birthdate , gamer.Description , country.nameFR countryName , videogame.idVIDEOGAME , videogame.Name gamevideoName , 
videogame.Description gamevideoDescription , videogame.Year gamevideoYear , editor.Name editorName , studio.Name studioName
FROM `gamer`
LEFT JOIN `country` USING(idCOUNTRY)
LEFT JOIN `gamer_videogame` gv ON idGamer = GAMER_idGAMER
LEFT JOIN `videogame` ON idVIDEOGAME = gv.VIDEOGAME_idVIDEOGAME
LEFT JOIN `editor` USING(idEditor)
LEFT JOIN `studio` USING(idStudio)
ORDER BY Name ASC	
";
				$gamersList = $conBdd->pdoExecute($sqlRequest);
				$gamersDisplayed = array();
				foreach ($gamersList as $gamer)
				{
					if (!in_array($gamer->idGAMER, $gamersDisplayed))
					{
						?>
						</table>
						<?php
						$gamersDisplayed[] = $gamer->idGAMER;
						?>
						<h4><?php echo $gamer->Name ?></h4>
						Date de naissance : <?php echo date('d/m/Y', strtotime($gamer->Birthdate)) ?><br/>
						Description : <?php echo $gamer->Description ?><br/>
						Pays : <?php echo $gamer->countryName ?><br/>
						Jeux vidéos :<br/>
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Nom</th>
									<th>Description</th>
									<th>Année de sortie</th>
									<th>Studio</th>
									<th>Éditeur</th>
								</tr>
							</thead>
							<?php
						}
						?>
						<tbody>
							<tr>
								<td><a href="view.php?view=videogameProfile&id=<?php echo $gamer->idVIDEOGAME ?>"><?php echo $gamer->gamevideoName ?></a></td>
								<td><?php echo shortString($gamer->gamevideoDescription) ?></td>
								<td><?php echo $gamer->gamevideoYear ?></td>
								<td><?php echo $gamer->studioName ?></td>
								<td><?php echo $gamer->editorName ?></td>
							</tr>
						</tbody>
						<?php
					}
					if (!empty($gamersDisplayed))
					{
						?>
					</table>
					<?php
				}
				?>
			</div>

			<div id="users">
				<h2 class="text-center">Utilisateurs</h2>
				<?php
				$sqlRequest = "
SELECT `user`.* , bet.* , `match`.Description matchDescription , `contest`.idCONTEST , `contest`.Name contestName
FROM `user`
LEFT JOIN `bet` bet ON idUSER = USER_idUSER
LEFT JOIN `match` ON MATCH_idMATCH = idMATCH
LEFT JOIN `contest` USING(idCONTEST)
ORDER BY Nickname ASC	
";
				$usersList = $conBdd->pdoExecute($sqlRequest);
				$usersDisplayed = array();
				foreach ($usersList as $user)
				{
					if (!in_array($user->idUSER, $usersDisplayed))
					{
						?>
						</table>
						<?php
						$usersDisplayed[] = $user->idUSER;
						?>
						<h4><?php echo $user->Nickname ?></h4>
						Prénom :<?php echo $user->First_Name ?><br/>
						Nom : <?php echo $user->Last_Name ?><br/>
						Date de naissance : <?php echo date('d/m/Y', strtotime($user->Birthdate)) ?><br/>
						Description : <?php echo $user->Description ?><br/>
						Banque : <?php echo $user->Bank ?><br/>
						Date d'enregistrement : <?php echo date('d/m/Y', strtotime($user->RegistrationDate)) ?><br/>
						Paris effectués :<br/>
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Compétition</th>
									<th>Match</th>
									<th>Argent mis en jeu</th>
									<th>Joueurs donnés gagnants</th>
								</tr>
							</thead>
							<?php
						}
						?>
						<tbody>
							<tr>
								<td><a href="contest.php&id=<?php echo $user->idCONTEST ?>"><?php echo $user->contestName ?></a></td>
								<td><a href="view.php?view=matchProfile&id=<?php echo $user->MATCH_idMATCH ?>"><?php echo $user->matchDescription ?></a></td>
								<td><?php echo $user->Price ?></td>
								<td><?php echo implode(', ', $conBdd->pdoExecute("SELECT Name FROM `gamer` LEFT JOIN `match_gamer` ON idGAMER = GAMER_idGAMER WHERE Side=:side AND MATCH_idMATCH=:idMatch", array(':side' => $user->Winner, ':idMatch' => $user->MATCH_idMATCH), true, PDO::FETCH_COLUMN)) ?></td>
							</tr>
						</tbody>
						<?php
					}
					if (!empty($usersDisplayed))
					{
						?>
					</table>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php
include("Footer.php");
?>
