<?php
include("Header.php");
include("Banniere.php");
echo "date -> " . getTimeStamp(getDate()) . "<br/>";
?>
<div class="row-fluid">  
	<div class="span3">
		Compétitions en cours : <br/>
		<?php
		$onGoingContests = $conBdd->pdoExecute("SELECT * FROM contest WHERE Startdate < UNIX_TIMESTAMP() AND Enddate = 0");
		if (count($onGoingContests) == 0)
			echo "Il n'y a pas de compétition en cours";
		else
			foreach ($onGoingContests as $contest)
				echo '<a href="view.php?view=contestProfile&id=' . $contest->idCONTEST . '">' . $contest->Name . '</a>, prix : ' . $contest->Price . '<br />';
		?>
	</div>
	<div class="span6">
		Prochaines compétitions : <br/>
		<?php
		$futureContests = $conBdd->pdoExecute("SELECT * FROM contest WHERE Startdate > UNIX_TIMESTAMP() ORDER BY Startdate ASC LIMIT 2");
		if (count($futureContests) == 0)
			echo "Il n'y a pas de compétition prevues";
		else
			foreach ($futureContests as $contest)
				echo '<a href="view.php?view=contestProfile&id=' . $contest->idCONTEST . '">' . $contest->Name . '</a>, prix : ' . $contest->Price . '<br />';
		?>
	</div>
	<div class="span3">
		Compétitions récemment terminées : <br/>
		<?php
		$lastFinishedContests = $conBdd->pdoExecute("SELECT * FROM contest WHERE Enddate < UNIX_TIMESTAMP() ORDER BY Enddate DESC LIMIT 2");
		if (count($lastFinishedContests) == 0)
			echo "Aucune";
		else
			foreach ($lastFinishedContests as $contest)
				echo '<a href="view.php?view=contestProfile&id=' . $contest->idCONTEST . '">' . $contest->Name . '</a>, prix : ' . $contest->Price . '<br />';
		?>
	</div>
</div>
<br/>
<hr/>
<br/>
<div class="row-fluid">  
    <div class="span3">
		Dernières compétitions ajoutées : <br/>
		<?php
		$contests = $conBdd->pdoExecute("SELECT * FROM contest ORDER BY idCONTEST DESC LIMIT 2");
		foreach ($contests as $contest)
			echo '<a href="view.php?view=contestProfile&id=' . $contest->idCONTEST . '">' . $contest->Name . '</a>, prix : ' . $contest->Price . '<br />';
		?>
	</div>
	<div class="span3">
		Derniers utilisateurs inscrits : <br/>
		<?php
		$users = $conBdd->pdoExecute("SELECT * FROM user ORDER BY idUSER DESC LIMIT 2");
		foreach ($users as $user)
			echo '<a href="view.php?view=userProfile&id=' . $user->idUSER . '">' . $user->Nickname . '</a>, banque : ' . $user->Bank . '<br />';
		?>
	</div>
	<div class="span3">
		Derniers joueurs : <br/>
		<?php
		$gamers = $conBdd->pdoExecute("SELECT * FROM gamer ORDER BY idGAMER DESC LIMIT 2");
		foreach ($gamers as $gamer)
			echo '<a href="view.php?view=gamerProfile&id=' . $gamer->idGAMER . '">' . $gamer->Name . '</a><br />';
		?>
	</div>
	<div class="span3">
		Derniers jeux vidéos ajoutés : <br/>
		<?php
		$games = $conBdd->pdoExecute("SELECT * FROM videogame ORDER BY idVIDEOGAME DESC LIMIT 2");
		foreach ($games as $game)
			echo '<a href="view.php?view=videogameProfile&id=' . $game->idVIDEOGAME . '">' . $game->Name . '</a><br />';
		?>
	</div>
</div>
<?php
include("Footer.php");
?>