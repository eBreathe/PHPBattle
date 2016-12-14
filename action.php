<?php
	require_once 'player.php';
	// Connexion à la base de donnée.
	$conection = 'mysql:host=localhost;dbname=perso';
	$pdo = new PDO ($conection, 'root','');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// Regarde quel action a été demandée.
	if(!empty($_POST["attack"])) {
		$name = $_POST["p1name"];
		$name2 = $_POST["p2name"];

		// Récupère joueur 1
		$reponse = $pdo->query("SELECT * FROM perso where name='$name'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p = $reponse->fetch();
		$player1 = new Player($p['name'],$p['classe'],$p['level'],$p['curLife'],$p['maxLife'],$p['curExp'],$p['maxExp'],$p['damage'],$p['nbKills'],$p['nbPots'], $p['cooldown']);
		
		$reponse->closeCursor();
		
		// Récupère joueur 2
		$reponse = $pdo->query("SELECT * FROM perso where name='$name2'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p2 = $reponse->fetch();
		$player2 = new Player($p2['name'],$p2['classe'],$p2['level'],$p2['curLife'],$p2['maxLife'],$p2['curExp'],$p2['maxExp'],$p2['damage'],$p2['nbKills'],$p2['nbPots'], $p2['cooldown']);
		
		$reponse->closeCursor();
		
		if($player2->getCurLife() - $player1->getDamage() > 0) {
			$degat = $player1->doDamage($player2);
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=1&degat=$degat");
		}
		else {
			$player1->doDamage($player2);
			header("Location: index.php?error=4");
		}
		$player2->save();
	}
	else {
		
	}
	
	
	if(!empty($_POST["attack1"])) {
		$name = $_POST["p1name"];
		$name2 = $_POST["p2name"];

	// Récupère joueur 1
		$reponse = $pdo->query("SELECT * FROM perso where name='$name'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p = $reponse->fetch();
		$player1 = new Player($p['name'],$p['classe'],$p['level'],$p['curLife'],$p['maxLife'],$p['curExp'],$p['maxExp'],$p['damage'],$p['nbKills'],$p['nbPots'], $p['cooldown']);
		
		$reponse->closeCursor();
		
		// Récupère joueur 2
		$reponse = $pdo->query("SELECT * FROM perso where name='$name2'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p2 = $reponse->fetch();
		$player2 = new Player($p2['name'],$p2['classe'],$p2['level'],$p2['curLife'],$p2['maxLife'],$p2['curExp'],$p2['maxExp'],$p2['damage'],$p2['nbKills'],$p2['nbPots'], $p2['cooldown']);
		
		$reponse->closeCursor();
		
		if($player1->getCurLife() - $player2->getDamage() > 0) {
			$degat = $player2->doDamage($player1);
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=2&degat=$degat");
		}
		else {
			$player2->doDamage($player1);
			header("Location: index.php?error=4");
		}
		$player1->save();
	}
	else {
		
	}
	
	if(!empty($_POST["popo"])) {
		$name = $_POST["p1name"];
		$name2 = $_POST["p2name"];

			// Récupère joueur 1
		$reponse = $pdo->query("SELECT * FROM perso where name='$name'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p = $reponse->fetch();
		$player1 = new Player($p['name'],$p['classe'],$p['level'],$p['curLife'],$p['maxLife'],$p['curExp'],$p['maxExp'],$p['damage'],$p['nbKills'],$p['nbPots'], $p['cooldown']);
		
		$reponse->closeCursor();
		
		// Récupère joueur 2
		$reponse = $pdo->query("SELECT * FROM perso where name='$name2'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p2 = $reponse->fetch();
		$player2 = new Player($p2['name'],$p2['classe'],$p2['level'],$p2['curLife'],$p2['maxLife'],$p2['curExp'],$p2['maxExp'],$p2['damage'],$p2['nbKills'],$p2['nbPots'], $p2['cooldown']);
		
		$reponse->closeCursor();
		
		if($player1->getNbPots() > 0)
		{
			if($player1->getCurLife() == $player1->getMaxLife())
			{
				header("Location: battle.php?display=1&name=$name&name2=$name2&logs=333");
			}
			else
			{
				$player1->takePotion(); 
				header("Location: battle.php?display=1&name=$name&name2=$name2&logs=3");
			}	
		}
		else
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=33");

	}
	
	if(!empty($_POST["popo1"])) {
		$name = $_POST["p1name"];
		$name2 = $_POST["p2name"];

		// Récupère joueur 1
		$reponse = $pdo->query("SELECT * FROM perso where name='$name'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p = $reponse->fetch();
		$player1 = new Player($p['name'],$p['classe'],$p['level'],$p['curLife'],$p['maxLife'],$p['curExp'],$p['maxExp'],$p['damage'],$p['nbKills'],$p['nbPots'], $p['cooldown']);
		
		$reponse->closeCursor();
		
		// Récupère joueur 2
		$reponse = $pdo->query("SELECT * FROM perso where name='$name2'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p2 = $reponse->fetch();
		$player2 = new Player($p2['name'],$p2['classe'],$p2['level'],$p2['curLife'],$p2['maxLife'],$p2['curExp'],$p2['maxExp'],$p2['damage'],$p2['nbKills'],$p2['nbPots'], $p2['cooldown']);
		
		$reponse->closeCursor();
		
		if($player2->getNbPots() > 0)
		{
			if($player2->getCurLife() == $player2->getMaxLife())
			{
				header("Location: battle.php?display=1&name=$name&name2=$name2&logs=444");
			}
			else
			{
				$player2->takePotion();
				header("Location: battle.php?display=1&name=$name&name2=$name2&logs=4");
			}
		}
		else
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=44");

	}
	
	if(!empty($_POST["soin"])) {
		$name = $_POST["p1name"];
		$name2 = $_POST["p2name"];

		// Récupère joueur 1
		$reponse = $pdo->query("SELECT * FROM perso where name='$name'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p = $reponse->fetch();
		$player1 = new Player($p['name'],$p['classe'],$p['level'],$p['curLife'],$p['maxLife'],$p['curExp'],$p['maxExp'],$p['damage'],$p['nbKills'],$p['nbPots'], $p['cooldown']);
		
		$reponse->closeCursor();
		
		// Récupère joueur 2
		$reponse = $pdo->query("SELECT * FROM perso where name='$name2'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p2 = $reponse->fetch();
		$player2 = new Player($p2['name'],$p2['classe'],$p2['level'],$p2['curLife'],$p2['maxLife'],$p2['curExp'],$p2['maxExp'],$p2['damage'],$p2['nbKills'],$p2['nbPots'], $p2['cooldown']);
		
		$reponse->closeCursor();
		
		if($player1->getCurLife() != $player1->getMaxLife())
		{
			$player1->setCooldown(date("s"));
			$soin = $player1->soin();
			
			$nextSpell = 0;
			if(date("s")>51) {
				$restant = 60 - date("s");
			}
			else {
				$restant = date("s") +10;
			}
			$nextSpell = $restant;
			header("Location: battle.php?display=1&name=$name&name2=$name2&gcd=1&logs=5&soin=$soin");
		}
		else
			header("Location: battle.php?display=1&name=$name&name2=$name2&gcd=1&logs=55");
		
	}
	
	if(!empty($_POST["soin1"])) {
		$name = $_POST["p1name"];
		$name2 = $_POST["p2name"];

		// Récupère joueur 1
		$reponse = $pdo->query("SELECT * FROM perso where name='$name'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p = $reponse->fetch();
		$player1 = new Player($p['name'],$p['classe'],$p['level'],$p['curLife'],$p['maxLife'],$p['curExp'],$p['maxExp'],$p['damage'],$p['nbKills'],$p['nbPots'], $p['cooldown']);
		
		$reponse->closeCursor();
		
		// Récupère joueur 2
		$reponse = $pdo->query("SELECT * FROM perso where name='$name2'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p2 = $reponse->fetch();
		$player2 = new Player($p2['name'],$p2['classe'],$p2['level'],$p2['curLife'],$p2['maxLife'],$p2['curExp'],$p2['maxExp'],$p2['damage'],$p2['nbKills'],$p2['nbPots'], $p2['cooldown']);
		
		$reponse->closeCursor();
		
		if($player2->getCurLife() != $player2->getMaxLife())
		{
			$player2->setCooldown(date("s"));
			$soin = $player2->soin();
			
			$nextSpell = 0;
			if(date("s")>51) {
				$restant = 60 - date("s");
			}
			else {
				$restant = date("s") +10;
			}
			$nextSpell = $restant;
			header("Location: battle.php?display=1&name=$name&name2=$name2&gcd=1&logs=6&soin=$soin");
		}
		else
			header("Location: battle.php?display=1&name=$name&name2=$name2&gcd=1&logs=66");
	}
	
	if(!empty($_POST["sort"])) {
		$name = $_POST["p1name"];
		$name2 = $_POST["p2name"];

		// Récupère joueur 1
		$reponse = $pdo->query("SELECT * FROM perso where name='$name'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p = $reponse->fetch();
		$player1 = new Player($p['name'],$p['classe'],$p['level'],$p['curLife'],$p['maxLife'],$p['curExp'],$p['maxExp'],$p['damage'],$p['nbKills'],$p['nbPots'], $p['cooldown']);
		
		$reponse->closeCursor();
		
		// Récupère joueur 2
		$reponse = $pdo->query("SELECT * FROM perso where name='$name2'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p2 = $reponse->fetch();
		$player2 = new Player($p2['name'],$p2['classe'],$p2['level'],$p2['curLife'],$p2['maxLife'],$p2['curExp'],$p2['maxExp'],$p2['damage'],$p2['nbKills'],$p2['nbPots'], $p2['cooldown']);
		
		$reponse->closeCursor();
		
		if($player1->getClasse()=="Mage") {
			$player2->setCooldown(date("s")+10);
			$player2->save();
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=7");
		}
		else if($player1->getClasse()=="Pretre") {
			$player1->setCooldown(-1);
			$player1->save();
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=8");
		}
		else if ($player1->getClasse()=="Assassin")
		{
			if($player2->getCurLife() - $player1->getDamage() > 0) {
				$player1->poison($player2);
				header("Location: battle.php?display=1&name=$name&name2=$name2&logs=9");
			}
			else 
			{
				$player1->poison($player2);
				header("Location: index.php?error=4");
			}	
			$player2->save();
		}
		else if ($player1->getClasse()=="Voleur")
		{
			if ($player2->getNbPots() > 0)
			{
				$Succes = $player1->vol($player2);
				if($Succes == 1)
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=10");
				else
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=12");
			}
			else
				header("Location: battle.php?display=1&name=$name&name2=$name2&logs=11");
		}
		else if ($player1->getClasse()=="Alchimiste")
		{
			if($player2->getCurLife() - $player1->getDamage() > 0) {
				if($player1->getNbPots() > 0)
				{
					$player1->potionAcid($player2);
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=13");
				}
				else
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=14");
			}
			else 
			{
				$player1->potionAcid($player2);
				header("Location: index.php?error=4");
			}	
			$player2->save();
		}
		else if ($player1->getClasse()=="Berserker")
		{
			if($player2->getCurLife() - $player1->getDamage() > 0) {
				if($player1->getCurLife() > 10)
				{
					$player1->rage($player2);
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=15");
				}
				else
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=16");
			}
			else 
			{
				$player1->rage($player2);
				header("Location: index.php?error=4");
			}	
			$player2->save();
		}
		else if ($player1->getClasse()=="Moine")
		{
			$player1->meditation();
			
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=17");
		}
	}
	
	if(!empty($_POST["sort1"])) {
		$name = $_POST["p1name"];
		$name2 = $_POST["p2name"];

		// Récupère joueur 1
		$reponse = $pdo->query("SELECT * FROM perso where name='$name'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p = $reponse->fetch();
		$player1 = new Player($p['name'],$p['classe'],$p['level'],$p['curLife'],$p['maxLife'],$p['curExp'],$p['maxExp'],$p['damage'],$p['nbKills'],$p['nbPots'], $p['cooldown']);
		
		$reponse->closeCursor();
		
		// Récupère joueur 2
		$reponse = $pdo->query("SELECT * FROM perso where name='$name2'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p2 = $reponse->fetch();
		$player2 = new Player($p2['name'],$p2['classe'],$p2['level'],$p2['curLife'],$p2['maxLife'],$p2['curExp'],$p2['maxExp'],$p2['damage'],$p2['nbKills'],$p2['nbPots'], $p2['cooldown']);
		
		$reponse->closeCursor();
		
		if($player2->getClasse()=="Mage") {
			$player1->setCooldown(date("s")+10);
			$player1->save();
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=77");
		}
		else if($player2->getClasse()=="Pretre") {
			$player2->setCooldown(-1);
			$player2->save();
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=88");
		}
		else if ($player2->getClasse()=="Assassin")
		{
			if($player1->getCurLife() - $player2->getDamage() > 0) {
				$player2->poison($player1);
				header("Location: battle.php?display=1&name=$name&name2=$name2&logs=99");
			}
			else {
				$player2->poison($player1);
				header("Location: index.php?error=4");
			}
			$player1->save();
		}
		else if ($player2->getClasse()=="Voleur")
		{
			if ($player1->getNbPots() > 0)
			{
				$Succes = $player2->vol($player1);
				if($Succes == 1)
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=1010");
				else
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=1212");
			}
			else
				header("Location: battle.php?display=1&name=$name&name2=$name2&logs=1111");
		}
		
		else if ($player2->getClasse()=="Alchimiste")
		{
			if($player1->getCurLife() - $player2->getDamage() > 0) {
				if($player2->getNbPots() > 0)
				{
					$player2->potionAcid($player1);
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=1313");
				}
				else
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=1414");
			}
			else {
				$player2->potionAcid($player1);
				header("Location: index.php?error=4");
			}
			$player1->save();
		}
		
		else if ($player2->getClasse()=="Berserker")
		{
			if($player1->getCurLife() - $player2->getDamage() > 0) {
				if($player2->getCurLife() > 10)
				{
					$player2->rage($player1);
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=1515");
				}
				else
					header("Location: battle.php?display=1&name=$name&name2=$name2&logs=1616");
			}
			else 
			{
				$player2->rage($player1);
				header("Location: index.php?error=4");
			}	
			$player1->save();
		}
		else if ($player2->getClasse()=="Moine")
		{
			$player2->meditation();
			
			header("Location: battle.php?display=1&name=$name&name2=$name2&logs=1717");
		}
	}
	
	
?>