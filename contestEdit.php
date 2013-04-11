<?php
include("Header.php");
include("Banniere.php");

print_r($_POST);
echo "<br/>";
$id = intval($_GET['id']);

if ($_POST){
	if($_POST['createMatch'])
	{
		$nomMatch = $_POST['nomMatch']!=""?$_POST['nomMatch']:"Match sans nom";
		$nbTeam = $_POST['nbTeam'];
		$nbTeammate = $_POST['nbTeammate'];
		
		if ($nbTeam > 0)
		{
			try {
				$success = $conBdd->pdoExecute("INSERT INTO `hackjackbet`.`match` (Description, StartDate, idContest) VALUES(
				:description, NOW(), :idContest)",array(
					':description'=>$nomMatch,
					':idContest'=>$id,
				));
				
				echo $lastinsertid = $conBdd->connexion->lastinsertid();
				$c = 0;
				for ($i = 1; $i <= $nbTeam; $i++)
				{
					for ($j = 1 ; $j <= $nbTeammate; $j++)
					{
						$success = $conBdd->pdoExecute("INSERT INTO `hackjackbet`.`match_gamer` VALUES(
						:idGamer, :idMatch, :side)",array(
							':idGamer'=>$_POST['teammate'][$c],
							':idMatch'=>$lastinsertid,
							':side'=>"team$i",
						));
						$c++;
					}
				}

				
				 
				echo "Enregistrement réussi";
			} catch( Exception $e ){
			  echo 'Erreur de requète : ', $e->getMessage();
			}
		}else{
			echo "Vous n'avez defini aucune equipe";
		}
		echo "<br/>";
	}
	else
	{
		if ($_POST['addScore'])
		{
			$side = $_POST['side'];
			$score = $_POST['score'];
			$idMatch =  $_POST['idMatch'];
			if ($score)
			{
				try {
					$success = $conBdd->pdoExecute("UPDATE `hackjackbet`.`match` SET 
					`match`.Enddate = NOW() WHERE `match`.idMATCH = :idMATCH",array(
						':idMATCH'=>$idMatch,
					));
					$success = $conBdd->pdoExecute("INSERT INTO `hackjackbet`.`score` VALUES(
					NULL, :score)",array(
						':score'=>$score,
					));
					echo $lastinsertid = $conBdd->connexion->lastinsertid();
					$success = $conBdd->pdoExecute("INSERT INTO `hackjackbet`.`match_score` VALUES(
					:idScore, :idMatch, :side)",array(
						':idScore'=>$lastinsertid,
						':idMatch'=>$idMatch,
						':side'=>$side,
					));
					
					 
					echo "Enregistrement du score réussi";
				} catch( Exception $e ){
				  echo 'Erreur de requète : ', $e->getMessage();
				}
			}else{
				echo "Veuillez definir un score";
			}
		}
	}
}


$contests = $conBdd->pdoExecute("SELECT * FROM contest WHERE idCONTEST=:id", array(':id' => $id));

$sqlRequest = "SELECT *
FROM `match` AS m
INNER JOIN match_gamer AS mg ON m.idMATCH = mg.MATCH_idMATCH
WHERE m.idCONTEST=:id
GROUP BY m.idMATCH";
$matches = $conBdd->pdoExecute($sqlRequest, array(':id' => $id));
if($contests)
{
	foreach ($contests as $contest)
	{?>
		Nom : <?php echo $contest->Name ?><br/>
		Prix : <?php echo $contest->Price ?><br/>
		Commencé le <?php echo getDateFormateeFromTimeStamp($contest->Startdate) ?><br/>
		Lieu : <?php echo $contest->Location ?><br/>
		<?php
		if ($contest->Enddate != 0)
		{
			echo 'Finie le : ' . getDateFormateeFromTimeStamp($contest->Enddate) . '<br />';
		}
		else
		{
			echo 'En cours..<br />';
		}
	}
	?>
	Concurrents : <br/>
	<?php
	if ($matches)
	{
		foreach ($matches as $match)
		{
			$sqlRequest = "SELECT *
				FROM match_gamer AS mg
				INNER JOIN gamer AS g ON g.idGAMER = mg.GAMER_idGAMER
				WHERE mg.MATCH_idMATCH=:id
				ORDER BY mg.Side";
			$competitors = $conBdd->pdoExecute($sqlRequest, array(':id' => $match->idMATCH));
			$first = true;
			$oldSide = -1;
			?>
			<p>
				<a href="view.php?view=matchProfile&id=<?php echo $match->idMATCH ?>"><?php echo $match->Description ?></a>
				<br/>

				<?php						
				if ($competitors)	
				{
					foreach ($competitors as $competitor)
					{
						if ($oldSide != $competitor->Side)
						{
							if (!$first)
							{
								echo "vs</br>";
							}
							$sqlRequest = "SELECT s.Score
							FROM `match`  AS m
							INNER JOIN match_score AS ms ON m.idMATCH = ms.MATCH_idMATCH
							INNER JOIN `score` AS s ON s.idSCORE = ms.SCORE_idSCORE
							WHERE ms.MATCH_idMATCH=:idMatch
							AND ms.Side = :Side";
							$score = $conBdd->pdoExecute($sqlRequest, array(':idMatch' => $match->idMATCH, ':Side' => $competitor->Side));
							$scoreTeam = $score[0]->Score?$score[0]->Score:"NC";
							
							echo $competitor->Side.", score : " . $scoreTeam . "<br/>";
							echo "<form action='contestEdit.php?id=$id' method='post'>";
								echo "<input type='text' name='score' size='4'/>";
								echo "<input type='hidden' name='addScore' value='1'>";
								echo "<input type='hidden' name='idMatch' value='".$match->idMATCH."'>";
								echo "<input type='hidden' name='side' value='".$competitor->Side."'>";
								echo "<input type='submit' value='Valider ce resultat'><br/>";
							echo "</form>";
						}
						$oldSide = $competitor->Side;
						$first = false;
						?>
						<a href="view.php?view=gamerProfile&id=<?php echo $competitor->idGAMER ?>"><?php echo $competitor->Name ?></a>
						<br/>

						<?php
					}
				}
				?>
		</p>
		<?php
		}
	}
	$gamers = $conBdd->pdoExecute("SELECT idGAMER, Name FROM gamer ORDER BY Name ASC");
	echo "<div id=gamersModele style='display:none'><select type='text' name='teammate[]'>";
	foreach($gamers as $gamer)
	{
		echo "<option value='$gamer->idGAMER'>$gamer->Name</option>";
	}
	echo "</select></div>";
	?>
	<script type="text/javascript">
	<!--
	var team = 0
	var contenu = ""
	var teammate = 1
	
	function newTeam(){
		team = team + 1;
		contenu = contenu + "<p>Team "+ team +" : ";
		document.getElementById('teams').innerHTML = contenu;
		for(t = 1 ; t <= teammate; t++){
			contenu =  contenu + "<label for='teammate" + t + "'>Equipier "+ t + "</label>" +document.getElementById('gamersModele').innerHTML + "</p>";
			document.getElementById('teams').innerHTML = contenu;
		}
		document.getElementById('nbteammate').innerHTML = "";
		document.getElementById('nbTeam').innerHTML = "<input type='hidden' name='nbTeam' value='" + team + "'>";
	}
	function majNbTeammate(){
		document.getElementById('nbTeammate').innerHTML = teammate +"<input type='hidden' name='nbTeammate' value='" + teammate + "'>";
	}
	function addTeammate(){
		teammate = teammate + 1;
		majNbTeammate()
	}
	function removeTeammate(){
		teammate = teammate - 1;
		teammate = teammate>0?teammate:1;
		majNbTeammate()
	}
	</script>

	Ajouter un match :
	<?php echo "<form action='contestEdit.php?id=$id' method='post'>"; ?>
		<p>Nom du match : <input type="text" name="nomMatch" /></p>
		<p>Nombre de coequipiers par equipe : <span id="nbTeammate">1<input type="hidden" name="nbTeammate" value="1"> </p>
		<span id="nbTeam"><input type="hidden" name="nbTeam" value="0"> </span>
		<p id="teams"><p>
		<input type="button" onclick="newTeam()" value="Ajouter une equipe"/>
		<span id="nbteammate"><input type="button" onclick="addTeammate()" value="Augmenter le nombre de coequipiers"/>
		<input type="button" onclick="removeTeammate()" value="Reduire le nombre de coequipiers"/></span>
		<input type="hidden" name="createMatch" value="1">
		<p><input type="submit" value="Valider ce match"></p>
	</form>
	<?php
}
include("Footer.php");