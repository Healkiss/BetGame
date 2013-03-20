<?php
include("Header.php");
include("Banniere.php");
$id = $_GET['id'];
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
$res->closeCursor();
echo "Concurrents : <br/>";
$res=$connexion->prepare("SELECT *
							FROM contest_match AS cm
							INNER JOIN match_gamer AS mg ON cm.MATCH_idMATCH = mg.MATCH_idMATCH
							INNER JOIN `match` AS m ON m.idMATCH = mg.MATCH_idMATCH
							WHERE cm.CONTEST_idCONTEST=:id
							GROUP BY m.idMATCH;
						");
$res->execute(array(':id' => $id));
while ($row = $res->fetch()) {
	echo "<p>";
	echo "<a href='view.php?view=matchProfil&id=".$row['idMATCH']."'>".$row['Description'] .'</a></br>';
	$res2=$connexion->prepare("SELECT *
							FROM match_gamer AS mg
							INNER JOIN gamer AS g ON g.idGAMER = mg.GAMER_idGAMER
							WHERE mg.MATCH_idMATCH=:id
							ORDER BY mg.Side;
						");
	$res2->execute(array(':id' => $row['idMATCH']));
	$first = true;
	$oldSide = -1;
	while ($row2 = $res2->fetch()) {
		if($oldSide != $row2['Side'])
			if (!$first)
				echo "vs</br>";
		$oldSide = $row2['Side'];
		echo "<a href='view.php?view=gamerProfil&id=".$row2['idGAMER']."'>".$row2['Name']."</a><br/>";
		$first = false;
	}
	echo "</p>";
}
$res->closeCursor();