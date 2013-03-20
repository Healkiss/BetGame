<?php
	include("Header.php");
	include("Banniere.php");
echo "date -> ". getTimeStamp(getDate()) ."<br/>";
?>
<div class="row-fluid">  
    <div class="span3">
		dernieres competitions : <br/>
		<?php
			$res=$connexion->query("SELECT * FROM contest ORDER BY idCONTEST DESC LIMIT 2");
			$res->setFetchMode(PDO::FETCH_OBJ);
			while( $ligne = $res->fetch() )
			{
			        echo '<a href="view.php?view=contestProfil&id=' . $ligne->idCONTEST . '">' . $ligne->Name . '</a>, prix : ' . $ligne->Price . '<br />';
			}
			$res->closeCursor();
		?>
	</div>
	<div class="span6">
		derniers inscrits : <br/>
		<?php
			$res=$connexion->query("SELECT * FROM user ORDER BY idUSER DESC LIMIT 2");
			$res->setFetchMode(PDO::FETCH_OBJ);
			while( $ligne = $res->fetch() )
			{
			        echo '<a href="view.php?view=userProfil&id=' . $ligne->idUSER . '">' . $ligne->Nickname . '</a>, banque : ' . $ligne->Bank . '<br />';
			}
			$res->closeCursor();
		?>
	</div>
	<div class="span3">
		derniers jeux : <br/>
		<?php
			$res=$connexion->query("SELECT * FROM videogame ORDER BY idVIDEOGAME DESC LIMIT 2");
			$res->setFetchMode(PDO::FETCH_OBJ);
			while( $ligne = $res->fetch() )
			{
			        echo '<a href="view.php?view=videogameProfil&id=' . $ligne->idVIDEOGAME . '">' . $ligne->Name . '</a><br />';
			}
			$res->closeCursor();
		?>
	</div>
</div>
<?php
	include("Footer.php");
?>