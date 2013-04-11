<?php
include("Header.php");
include("Banniere.php");
?>
<div class="row-fluid">  
	<div class="span3">
		Compétitions en cours : <br/>
		<?php
		$onGoingContests = $conBdd->pdoExecute("SELECT * FROM contest WHERE Startdate < NOW() AND Enddate = 0");
		if (count($onGoingContests) == 0)
			echo "Il n'y a pas de compétition en cours";
		else
			foreach ($onGoingContests as $contest)
				echo '<a href="view.php?view=contestProfile&id=' . $contest->idCONTEST . '">' . $contest->Name . '</a>, prix : ' . $contest->Price . '<br />';
		?>
	</div>
	<div class="span3">
		Prochaines compétitions : <br/>
		<?php
		$futureContests = $conBdd->pdoExecute("SELECT * FROM contest WHERE Startdate > NOW() ORDER BY Startdate ASC LIMIT 2");
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
		$lastFinishedContests = $conBdd->pdoExecute("SELECT * FROM contest WHERE Enddate < NOW() ORDER BY Enddate DESC LIMIT 2");
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
		Matchs en cours : <br/>
		<?php
		$onGoingMatches = $conBdd->pdoExecute("
			SELECT m.* , contest.Name contestName
			FROM `match` AS m
			LEFT JOIN contest USING(idCONTEST) 
			WHERE m.Startdate < NOW()
				AND m.Enddate = 0
			ORDER BY m.Startdate DESC");
		if (count($onGoingMatches) == 0)
			echo "Il n'y a pas de match qui se déroule en ce moment.";
		else
			foreach ($onGoingMatches as $match)
				echo '<a href="view.php?view=matchProfile&id=' . $match->idMATCH . '">' . $match->contestName . ' - ' . $match->Description . '</a><br />';
		?>
	</div>
	<div class="span3">
		Prochains matchs : <br/>
		<?php
		$futureMatches = $conBdd->pdoExecute("
			SELECT m.* , contest.Name contestName
			FROM `match` AS m
			LEFT JOIN contest USING(idCONTEST) 
			WHERE m.Startdate > NOW()
			ORDER BY m.Startdate ASC");
		if (count($futureMatches) == 0)
			echo "Il n'y a aucun match planifié.";
		else
			foreach ($futureMatches as $match)
				echo '<a href="view.php?view=matchProfile&id=' . $match->idMATCH . '">' . $match->contestName . ' - ' . $match->Description . '</a><br />';
		?>
	</div>
	<div class="span3">
		Matchs récemment terminés : <br/>
		<?php
		$lastFinishedMatches = $conBdd->pdoExecute("
			SELECT m.* , contest.Name contestName
			FROM `match` m 
			LEFT JOIN contest USING(idCONTEST) 
			WHERE m.Enddate < NOW()
			ORDER BY m.Enddate DESC");
		if (count($lastFinishedMatches) == 0)
			echo "Aucun.";
		else
			foreach ($lastFinishedMatches as $match)
				echo '<a href="view.php?view=matchProfile&id=' . $match->idMATCH . '">' . $match->contestName . ' - ' . $match->Description . '</a><br />';
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
<br/>
<hr/>
<br/>
<div class="row-fluid text-center"> 
	<h3><a href="list.php">Accéder aux listes</a></h3>
</div> 
<?php
include("Footer.php");
?>