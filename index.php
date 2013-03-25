<?php
include("Header.php");
include("Banniere.php");
echo "date -> " . getTimeStamp(getDate()) . "<br/>";
?>
<div class="row-fluid">  
    <div class="span3">
		Dernières compétitions : <br/>
		<?php
		$contests = $conBdd->pdoExecute("SELECT * FROM contest ORDER BY idCONTEST DESC LIMIT 2");
		foreach ($contests as $contest)
			echo '<a href="view.php?view=contestProfil&id=' . $contest->idCONTEST . '">' . $contest->Name . '</a>, prix : ' . $contest->Price . '<br />';
		?>
	</div>
	<div class="span6">
		Derniers inscrits : <br/>
		<?php
		$users = $conBdd->pdoExecute("SELECT * FROM user ORDER BY idUSER DESC LIMIT 2");
		foreach ($users as $user)
			echo '<a href="view.php?view=userProfil&id=' . $user->idUSER . '">' . $user->Nickname . '</a>, banque : ' . $user->Bank . '<br />';
		?>
	</div>
	<div class="span3">
		Derniers jeux vidéos ajoutés : <br/>
		<?php
		$games = $conBdd->pdoExecute("SELECT * FROM videogame ORDER BY idVIDEOGAME DESC LIMIT 2");
		foreach ($games as $game)
			echo '<a href="view.php?view=videogameProfil&id=' . $game->idVIDEOGAME . '">' . $game->Name . '</a><br />';
		?>
	</div>
</div>
<?php
include("Footer.php");
?>