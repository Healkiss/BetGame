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
if($contests){
	foreach ($contests as $contest)
	{
		?>
		Nom : <?php echo $contest->Name ?><br/>
		Description : <?php echo $contest->Description ?><br/>
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
			echo 'En cours…<br />';
		}
	}?>
	Concurrents : <br/>
	<?php	if ($matches)	{
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

				<?php										if ($competitors)					{
					foreach ($competitors as $competitor)
					{
						if ($oldSide != $competitor->Side){
							if (!$first){
								echo "vs</br>";
							}
							$sqlRequest = "SELECT s.Score
							FROM `match` AS m
							INNER JOIN match_score AS ms ON m.idMATCH = ms.MATCH_idMATCH
							INNER JOIN `score` AS s ON s.idSCORE = ms.SCORE_idSCORE
							WHERE ms.MATCH_idMATCH=:idMatch
							AND ms.Side = :Side";
							$score = $conBdd->pdoExecute($sqlRequest, array(':idMatch' => $match->idMATCH, ':Side' => $competitor->Side));
							
							$scoreTeam = $score[0]->Score?$score[0]->Score:"NC";
							
							echo $competitor->Side.", score : " . $scoreTeam. "<br/>";;
							$oldSide = $competitor->Side;
							$first = false;
						}
						?>
						<a href="view.php?view=gamerProfile&id=<?php echo $competitor->idGAMER ?>"><?php echo $competitor->Name ?></a>
						<br/>

						<?php
					}				}
				?>
		</p>
		<?php
		}	}}
?>
<a href="contestEdit.php?id=<?php echo $contest->idCONTEST ?>">Modifier la competition</a>
<?php
include("Footer.php");?>