<?php
include("Header.php");
include("Banniere.php");

$id = intval($_GET['id']);

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
	{
		?>
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
				<a href="view.php?view=matchProfil&id=<?php echo $match->idMATCH ?>"><?php echo $match->Description ?></a>
				<br/>

				<?php						
				if ($competitors)	
				{
					foreach ($competitors as $competitor)
					{
						if ($oldSide != $competitor->Side)
							if (!$first)
								echo "vs</br>";
						$oldSide = $competitor->Side;
						$first = false;
						?>
						<a href="view.php?view=gamerProfil&id=<?php echo $competitor->idGAMER ?>"><?php echo $competitor->Name ?></a>
						<br/>

						<?php
					}
				}
				?>
		</p>
		<?php
		}
	}
	?>
	<script type="text/javascript">
	<!--
	var team = 0
	var contenu = ""
	var teammate = 1
	
	function newTeam(){
		team = team + 1;
		contenu = contenu + "Team "+ team +" : ";
		document.getElementById('new_team').innerHTML = contenu;
		for(t = 1 ; t <= teammate; t++){
			contenu =  contenu + "<label for='teammate" + t + "'>Equipier "+ t +" <input type='text' name='teammate" + t + "' /><br />";
			document.getElementById('new_team').innerHTML = contenu;
		}
		document.getElementById('nbteammate').innerHTML = "";
	}
	function majNbTeammate(){
		document.getElementById('nbCoequipier').innerHTML = " " + teammate +" ";
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
	<form action="contestEdit.php" method="post">
		<p>Nom du match : <input type="text" name="nomMatch" /></p>
		<p>Nombre de coequipiers par equipe : <span id="nbCoequipier">1 </span></p>
		<div id="new_team"></div>
		<input type="button" onclick="newTeam()" value="Ajouter une equipe"/>
		<span id="nbteammate"><input type="button" onclick="addTeammate()" value="Augmenter le nombre de coequipiers"/>
		<input type="button" onclick="removeTeammate()" value="Reduire le nombre de coequipiers"/></span>
		<p><input type="submit" value="OK"></p>
	</form>
	<?php
}
include("Footer.php");