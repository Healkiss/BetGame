<?php
include("Header.php");
include("Banniere.php");
?>
<div class="bs-docs-example">
	<?php

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
	$list = $conBdd->pdoExecute($sqlRequest);
	$gamersDisplayed = array();
	foreach ($list as $gamer)
	{
		if (!in_array($gamer->idGAMER, $gamersDisplayed))
		{
			?>
		</table>
		<?php
		$gamersDisplayed[] = $gamer->idGAMER;
		?>
		<h3><?php echo $gamer->Name ?></h3>
		Date de naissance : <?php echo date('d/m/y', strtotime($gamer->Birthdate)) ?><br/>
		Description : <?php echo $gamer->Description ?><br/>
		Pays : <?php echo $gamer->countryName ?><br/>
		Jeux vidéos :<br/>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Type de jeu</th>
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
				<td><?php echo $gamer->typeName ?></td>
				<td><?php echo shortString($gamer->gamevideoDescription) ?></td>
				<td><?php echo $gamer->gamevideoYear ?></td>
				<td><?php echo $gamer->studioName ?></td>
				<td><?php echo $gamer->editorName ?></td>
			</tr>
		</tbody>
		<?php
	}
	?>
</div>
<?php
ob_start();
include("Footer.php");
ob_end_flush();
?>
