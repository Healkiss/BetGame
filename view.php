<?php
/*
 * 
 Resumé de chaque classe
 Visuel de chaque table
 
 */
include("Header.php");
include("Banniere.php");
$view = $_GET['view'];
$id = $_GET['id'];
if ($view == 'userProfil'){
	$res=$connexion->prepare("SELECT * FROM user WHERE idUSER=:id");
	$res->execute(array(':id' => $id));
    $res->setFetchMode(PDO::FETCH_OBJ);
	while( $ligne = $res->fetch() ){
	    echo 'Utilisateur : ' . $ligne->Nickname . '<br />';
		echo 'Nom complet : ' . $ligne->Name . '</br/>';
		echo 'Banque : ' . $ligne->Bank. '</br/>';
		echo 'Date d\'inscription : ' . getDateFormateeFromTimeStamp($ligne->RegistrationDate);
	}
	$res->closeCursor();
}

if ($view == 'contestProfil'){
	$res=$connexion->prepare("SELECT * FROM contest WHERE idCONTEST=:id");
	$res->execute(array(':id' => $id));
    $res->setFetchMode(PDO::FETCH_OBJ);
	while( $ligne = $res->fetch() ){
	    echo 'Nom : ' . $ligne->Name . '<br />';
		echo 'Prix : ' . $ligne->Price . '<br />';
		echo 'Commencé le ' . getDateFormateeFromTimeStamp($ligne->Startdate) . '<br />';
		echo 'Lieu : ' . $ligne->Location . '<br />';
		if($ligne->Enddate != 0){
			echo 'Finie le : ' . getDateFormateeFromTimeStamp($ligne->Enddate) . '<br />';
		}else{
			echo 'En cours..<br />';
		}
	}
	echo "<a href='contest.php?id=".$id."'>Voir les participants à cette competition.</a>";
	$res->closeCursor();
}

if ($view == 'videogameProfil'){
	$res=$connexion->prepare("SELECT * FROM videoGame WHERE idVIDEOGAME=:id");
	$res->execute(array(':id' => $id));
    $res->setFetchMode(PDO::FETCH_OBJ);
	while( $ligne = $res->fetch() ){
	    echo 'Nom : ' . $ligne->Name . '<br />';
		echo 'Studio : ' . $ligne->Studio . '</br/>';
		echo 'Editeur : ' . $ligne->Editor;
	}
	$res->closeCursor();
}

if ($view == 'matchProfil'){
	$res=$connexion->prepare("SELECT * FROM match WHERE idMATCH=:id");
	$res->execute(array(':id' => $id));
    $res->setFetchMode(PDO::FETCH_OBJ);
	while( $ligne = $res->fetch() ){
	    echo 'Description : ' . $ligne->Name . '<br />';
			$res2=$connexion->prepare("SELECT *
							FROM match_gamer AS mg
							INNER JOIN gamer AS g ON g.idGAMER = mg.GAMER_idGAMER
							WHERE mg.MATCH_idMATCH=:id;
						");
		$res2->execute(array(':id' => $id));
		while ($row2 = $res2->fetch()) {
			echo "\t<a href='view.php?view=userProfil&id=".$row2['idGAMER']."'>".$row2['Name']."</a><br/>";
		}
	}
	$res->closeCursor();
}

if ($view == 'gamerProfil'){
	$res=$connexion->prepare("SELECT * FROM gamer WHERE idGAMER=:id");
	$res->execute(array(':id' => $id));
    $res->setFetchMode(PDO::FETCH_OBJ);
	while( $ligne = $res->fetch() ){
	    	    echo 'Nom : ' . $ligne->Name . '<br />';
	}
	$res->closeCursor();
}
include("Footer.php");
?>