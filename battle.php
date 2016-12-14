<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="script.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css" id="css" />
		<title>Combat personnages</title>
	</head>
	<body>
	<p style="text-align:center"><a href="index.php"><img src="images/top-bar1.png"></a></p>

	<?php
		require_once 'player.php';
		
		try
		{
			$conection = 'mysql:host=localhost;dbname=perso';
			$pdo = new PDO ($conection, 'root','');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			$msg = 'ERREUR PDO dans '.$e->getFile() . 'Ligne : ' . $e->getLine() . ' : ' . $e->getMessage();
			die($msg);
		}
	?>

	<?php
		if (isset($_POST['submit']))
		{
			// Get entered informations
			// Check if 'personnage' is not empty
			if(!empty($_POST['personnage'])) {
				// Check if 'classe' is selected
				if(isset($_POST['classe'])) {
					// Tests done.
					$name = $_POST['personnage'];
					$classe = $_POST['classe'];
					$request = $pdo->query('SELECT * FROM perso');
					// Get how many accounts are in the database
					$count = 0;
					while($accounts = $request->fetch()) {
						$count++;
					}
					// check if account exist
					$account = $pdo->query("SELECT COUNT(*) FROM perso WHERE name = '$name'")->fetchColumn();
					if($account!=0) {
						// good, let's start the game
						if ($count > 1) {
							game_start($name);
						}
						else {
							header('Location: index.php?error=1');
						}
					} 
					else {
						// Player not exist, let's create it.
						$player = new Player($name, $classe, 1, 100, 100, 0, 100, 5, 0, 5, -1);
						$player->insert();
						if($count > 0) {
							game_start($player->getName());
						}
						else {
							header('Location: index.php?error=1');
						}
					}
				}
				else {
					header('Location: index.php?error=3');
				}
			}
			else {
				header('Location: index.php?error=2');
			}
		}
	?>

	<?php
		function refreshBattle($player1, $player2) {
			echo "<!DOCTYPE html>
				  <html>
		    	  <body>
				  <br><br><br><br><br>
				  <table border='1' align='center'> <td>
				  <center><table><tr> <td> Nom: <b>" . $player1->getName() .
				  "</b></td><td></td> <td> Nom: <b>" . $player2->getName() . 
				  "</b></td></tr>";
					
					
		// DISPLAY IMAGES PLAYER 1
		if($player1->getClasse()=="Guerrier")
			echo "<tr><td> <img src='images/guerrierGauche.png' />"."</td>";
		else if ($player1->getClasse()=="Pretre")
			echo "<tr><td> <img src='images/priestGauche.png' />"."</td>";
		else if ($player1->getClasse()=="Mage")
			echo "<tr><td> <img src='images/mageSkin1Gauche.png' />"."</td>";
		else if ($player1->getClasse()=="Assassin")
			echo "<td> <img src='images/assassinGauche.png' />"."</td>";
		else if ($player1->getClasse()=="Voleur")
			echo "<td> <img src='images/voleurGauche.png' />"."</td>";
		else if ($player1->getClasse()=="Alchimiste")
			echo "<td> <img src='images/alchimisteGauche.png' />"."</td>";
		else if ($player1->getClasse()=="Berserker")
			echo "<td> <img src='images/berserkerGauche.png' />"."</td>";
		else if ($player1->getClasse()=="Moine")
			echo "<td> <img src='images/moineGauche.png' />"."</td>";
					
		// DISPLAY VERSUS
		echo "<td> <img src='images/vs.png' />"."</td>";

		// DISPLAY IMAGES PLAYER 2
		if($player2->getClasse()=="Guerrier")
			echo "<td> <img src='images/guerrierDroite.png' />"."</td>";
		else if ($player2->getClasse()=="Pretre")
			echo "<td> <img src='images/priestDroite.png' />"."</td>";
		else if ($player2->getClasse()=="Mage")
			echo "<td> <img src='images/mageSkin1Droite.png' />"."</td></tr>";
		else if ($player2->getClasse()=="Assassin")
			echo "<td> <img src='images/assassinDroite.png' />"."</td>";
		else if ($player2->getClasse()=="Voleur")
			echo "<td> <img src='images/voleurDroite.png' />"."</td>";
		else if ($player2->getClasse()=="Alchimiste")
			echo "<td> <img src='images/alchimisteDroite.png' />"."</td>";
		else if ($player2->getClasse()=="Berserker")
			echo "<td> <img src='images/berserkerDroite.png' />"."</td>";
		else if ($player2->getClasse()=="Moine")
			echo "<td> <img src='images/moineDroite.png' />"."</td>";

		// DISPLAY PLAYERS INFORMATIONS
		echo "<tr> <td> Niveau: " . $player1->getLevel() . "</td>".
		     "<td>"."</td>".
			 "<td> Niveau: " . $player2->getLevel() . "</td></tr>".
					
			 "<tr> <td> PV: " . $player1->getCurLife() . "/" . $player1->getMaxLife() . "</td>".
		     "<td>"."</td>".
		     "<td> PV: " . $player2->getCurLife() . "/" . $player2->getMaxLife() . "</td></tr>".
					
		     "<tr> <td> Attaque: " . $player1->getDamage() . "</td>".
		     "<td>"."</td>".
		     "<td> Attaque: " . $player2->getDamage() . "</td></tr>".
					
		     "<tr> <td> Potions: " . $player1->getNbPots() . "</td>".
		     "<td>"."</td>".
			 "<td> Potions: " .  $player2->getNbPots() . "</td></tr>";
					
		$name1 = $player1->getName();
		$name2 = $player2->getName();
			
			if($player1->getClasse()=="Guerrier")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player1->setCooldown(-1);
									$player1->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player1->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack'/> 
									  <input type='submit' value='Sort: Blocage' name='sort'/> 
									  <input type='submit' value='Prendre popo' name='popo'/>";
							}
							else {
								$timeLeft = $player1->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Blocage</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player1->getClasse()=="Mage")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player1->setCooldown(-1);
									$player1->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player1->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack'/> 
									  <input type='submit' value='Sort: Sommeil' name='sort'/> 
									  <input type='submit' value='Prendre popo' name='popo'/>";
							}
							else {
								$timeLeft = $player1->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Sommeil</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if ($player1->getClasse()=="Pretre")
			{
				echo "<tr> <td> 
					<form method='POST' action='action.php'> 
						<input type='hidden' name='p1name' value='$name1'/> 
						<input type='hidden' name='p2name' value='$name2'/> 
						<input type='submit' value='Attaquer' name='attack'/> 
						<input type='submit' value='Sort: Anti-sommeil' name='sort'/>
						<input type='submit' value='Soin' name='soin'/> 						
						<input type='submit' value='Prendre popo' name='popo'/>
					</form>  </td>";
			}
			else if($player1->getClasse()=="Assassin")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player1->setCooldown(-1);
									$player1->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player1->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack'/> 
									  <input type='submit' value='Sort: Dague empoisonnée' name='sort'/> 
									  <input type='submit' value='Prendre popo' name='popo'/>";
							}
							else {
								$timeLeft = $player1->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Dague empoisonnée</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player1->getClasse()=="Voleur")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player1->setCooldown(-1);
									$player1->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player1->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack'/> 
									  <input type='submit' value='Sort: Vol' name='sort'/> 
									  <input type='submit' value='Prendre popo' name='popo'/>";
							}
							else {
								$timeLeft = $player1->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Vol</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player1->getClasse()=="Alchimiste")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player1->setCooldown(-1);
									$player1->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player1->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack'/> 
									  <input type='submit' value='Sort: Potions acides' name='sort'/> 
									  <input type='submit' value='Prendre popo' name='popo'/>";
							}
							else {
								$timeLeft = $player1->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Potions acides</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player1->getClasse()=="Berserker")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player1->setCooldown(-1);
									$player1->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player1->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack'/> 
									  <input type='submit' value='Sort: Rage' name='sort'/> 
									  <input type='submit' value='Prendre popo' name='popo'/>";
							}
							else {
								$timeLeft = $player1->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Rage</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}						
			else if($player1->getClasse()=="Moine")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player1->setCooldown(-1);
									$player1->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player1->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack'/> 
									  <input type='submit' value='Sort: Méditation' name='sort'/> 
									  <input type='submit' value='Prendre popo' name='popo'/>";
							}
							else {
								$timeLeft = $player1->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Méditation</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			
			echo "<td>"."</td>";
			
			if($player2->getClasse()=="Guerrier")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player2->setCooldown(-1);
									$player2->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player2->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack1'/> 
									  <input type='submit' value='Sort: Blocage' name='sort1'/> 
									  <input type='submit' value='Prendre popo' name='popo1'/>";
							}
							else {

								// Imaginons il cast à 30 secondes.
								// Il peut taper à 40.
								// Le temps restant = $player2->getCooldown() - date("s");
								$timeLeft = $player2->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Blocage</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player2->getClasse()=="Mage")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player2->setCooldown(-1);
									$player2->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player2->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack1'/> 
									  <input type='submit' value='Sort: Sommeil' name='sort1'/> 
									  <input type='submit' value='Prendre popo' name='popo1'/>";
							}
							else {
								$timeLeft = $player2->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Sommeil</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player2->getClasse()=="Pretre")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player2->setCooldown(-1);
									$player2->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player2->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack1'/> 
									  <input type='submit' value='Sort: Anti-sommeil' name='sort1'/> 
									  <input type='submit' value='Soin' name='soin1'/>
									  <input type='submit' value='Prendre popo' name='popo1'/>";
							}
							else {
								// Imaginons il cast à 30 secondes.
								// Il peut taper à 40.
								// Le temps restant = $player2->getCooldown() - date("s");
								$timeLeft = $player2->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/>";
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<input type='submit' value='Sort: Anti-sommeil' name='sort1'/> ";
								echo "<button type='button' disabled>Soin</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			if($player2->getClasse()=="Assassin")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player2->setCooldown(-1);
									$player2->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player2->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack1'/> 
									  <input type='submit' value='Sort: Dague empoisonnée' name='sort1'/> 
									  <input type='submit' value='Prendre popo' name='popo1'/>";
							}
							else {
								$timeLeft = $player2->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Dague empoisonnée</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player2->getClasse()=="Voleur")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player2->setCooldown(-1);
									$player2->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player2->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack1'/> 
									  <input type='submit' value='Sort: Vol' name='sort1'/> 
									  <input type='submit' value='Prendre popo' name='popo1'/>";
							}
							else {
								$timeLeft = $player2->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Vol</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player2->getClasse()=="Alchimiste")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player2->setCooldown(-1);
									$player2->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player2->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack1'/> 
									  <input type='submit' value='Sort: Potions acides' name='sort1'/> 
									  <input type='submit' value='Prendre popo' name='popo1'/>";
							}
							else {
								$timeLeft = $player2->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Vol</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player2->getClasse()=="Berserker")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player2->setCooldown(-1);
									$player2->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player2->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack1'/> 
									  <input type='submit' value='Sort: Rage' name='sort1'/> 
									  <input type='submit' value='Prendre popo' name='popo1'/>";
							}
							else {
								$timeLeft = $player2->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Vol</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			else if($player2->getClasse()=="Moine")
			{
				echo "<td> 
					  <form method='POST' action='action.php'>";
							
							if(isset($_GET['cd2'])) {
									echo "gcd ok";
									$player2->setCooldown(-1);
									$player2->save();
									header("Location: battle.php?display=1&name=$name1&name2=$name2&logs=70");
							}

							if($player2->getCooldown()==-1) {
								echo "<input type='hidden' name='p1name' value='$name1'/> 
									  <input type='hidden' name='p2name' value='$name2'/> 
									  <input type='submit' value='Attaquer' name='attack1'/> 
									  <input type='submit' value='Sort: Méditation' name='sort1'/> 
									  <input type='submit' value='Prendre popo' name='popo1'/>";
							}
							else {
								$timeLeft = $player2->getCooldown() - date("s");
								$timeLeft = $timeLeft * 1000;
								echo "<button type='button' disabled>Attaquer</button> ";
								echo "<button type='button' disabled>Sort: Vol</button> ";
								echo "<button type='button' disabled>Prendre popo</button> ";
								echo "<script type='text/javascript'>
										function display_buttons() {
											window.open('battle.php?display=1&name=$name1&name2=$name2&cd2&logs=70', '_self');
										}
										setTimeout(display_buttons, $timeLeft);
									</script>";
							}
					echo "</form> </td>";
			}
			
			echo "</td></tr></table></center>";	
			echo "</td></table>";
			echo "</body>";
			echo "</html>";
	}
?>
<?php
	function game_start($player) {
		$conection = 'mysql:host=localhost;dbname=perso';
		$pdo = new PDO ($conection, 'root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
		// Récupère joueur 1
		$reponse = $pdo->query("SELECT * FROM perso where name='$player'");
		$reponse->setFetchMode(PDO::FETCH_CLASS, 'personnages');
		$p = $reponse->fetch();
		$player1 = new Player($p['name'],$p['classe'],$p['level'],$p['curLife'],$p['maxLife'],$p['curExp'],$p['maxExp'],$p['damage'],$p['nbKills'],$p['nbPots'], $p['cooldown']);
		
		$reponse->closeCursor();
		
		// Récupère joueur 2
		// Random dans la base de donnée pour le choisir
		$reponse2 = $pdo->query("SELECT * FROM perso ORDER BY rand() limit 1");
		$p2 = $reponse2->fetch();
		// Si le joueur 2 sélectionné au hasard est le notre, on re-rand
		while($p2['name']==$player1->getName()) {
			$reponse2 = $pdo->query("SELECT * FROM perso ORDER BY rand() limit 1");
			$p2 = $reponse2->fetch();
		}
		// affecte les données à un objet personnage
		$player2 = new Player($p2['name'],$p2['classe'],$p2['level'],$p2['curLife'],$p2['maxLife'],$p2['curExp'],$p2['maxExp'],$p2['damage'],$p2['nbKills'],$p2['nbPots'], $p2['cooldown']);
		
		$reponse2->closeCursor();
		
		refreshBattle($player1, $player2, "hit");
	}
?>

<?php
	if (isset($_GET['display'])) {
		$name = $_GET["name"];
		$name2 = $_GET["name2"];

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
		
		refreshBattle($player1, $player2);
	}
?>

<?php
	echo "<center><br><fieldset>
		  <legend> Journal de combat </legend>";

		if(isset($_GET['display'])) {
			$value = $_GET['logs'];
			if($value==70)
				echo "<b>". $_GET['name2'] . "</b> se réveille après 10 secondes.";
			if($value==0)
				echo "Début du combat.";
			
			//Log en rapport avec l'attaque
			if($value==1)
				echo "<b>". $_GET['name'] . "</b> attaque et inflige <font color='red'>" . $_GET['degat'] . "</font> points de dégats à <b>" . $_GET['name2'] . "</b>.";
			if($value==2)
				echo "<b>". $_GET['name2'] . "</b> attaque et inflige <font color='red'>" . $_GET['degat'] . "</font> points de dégats à <b>" . $_GET['name'] . "</b>.";
			
			//Log en rapport avec les potions
			if($value==3)
				echo "<b>". $_GET['name'] . "</b> utilise une potion.";
			if($value == 33)
				echo "<b>". $_GET['name'] . "</b> n'a plus assez de potion.";
			if($value == 333)
				echo "<b>". $_GET['name'] . "</b> potion échoue, PV max.";
			if($value==4)
				echo "<b>". $_GET['name2'] . "</b> utilise une potion.";
			if($value == 44)
				echo "<b>". $_GET['name2'] . "</b> n'a plus assez de potion.";
			if($value == 444)
				echo "<b>". $_GET['name2'] . "</b> potion échoue, PV max.";
			
			//Log en rapport avec le soin (Sort 2 du pretre)
			if($value==5)
				echo "<b>". $_GET['name'] . "</b> se soigne de <font color='green'>" . $_GET['soin'] . "</font>";
			if($value==55)
				echo "<b>". $_GET['name'] . "</b> essaye de se soigner sans succes ... PV max.";
			if($value==6)
				echo "<b>". $_GET['name2'] . "</b> se soigne de <font color='green'>" . $_GET['soin'] . "</font>";
			if($value==66)
				echo "<b>". $_GET['name2'] . "</b> essaye de se soigner sans succes ... PV max.";
			
			//Log en rapport avec les sorts de classe
			//Mage
			if($value==7)
				echo "<b>". $_GET['name'] . "</b> utilise son sort de sommeil.";
			if($value==77)
				echo "<b>". $_GET['name2'] . "</b> utilise son sort de sommeil.";
			//Pretre
			if($value==8)
				echo "<b>". $_GET['name'] . "</b> utilise son sort d'anti-sommeil.";
			if($value==88)
				echo "<b>". $_GET['name2'] . "</b> utilise son sort d'anti-sommeil.";
			//Assassin
			if($value==9)
				echo "<b>". $_GET['name'] . "</b> utilise son sort de dague empoisonnée.";
			if($value==99)
				echo "<b>". $_GET['name2'] . "</b> utilise son sort de dague empoisonnée.";
			//Voleur
			if($value==10)
				echo "<b>". $_GET['name'] . "</b> vol une potion à <b>" . $_GET['name2'] . "</b>";
			if($value==11)
				echo "<b>". $_GET['name'] . "</b> essaye de voler sans succès, <b>" . $_GET['name2'] . "</b> n'a plus de potion.";
			if($value==12)
				echo "<b>". $_GET['name'] . "</b> à raté son vol.";
			if($value==1010)
				echo "<b>". $_GET['name2'] . "</b> vol une potion à <b>" . $_GET['name'] . "</b>";
			if($value==1111)
				echo "<b>". $_GET['name2'] . "</b> essaye de voler sans succès, <b>" . $_GET['name'] . "</b> n'a plus de potion.";
			if($value==1212)
				echo "<b>". $_GET['name2'] . "</b> à raté son vol.";
			//Alchimiste
			if($value==13)
				echo "<b>". $_GET['name'] . "</b> utilise son sort de potion acide.";
			if($value==14)
				echo "<b>". $_GET['name'] . "</b> essaye d'utiliser potion acide sans succès, plus assez de potion.";
			if($value==1313)
				echo "<b>". $_GET['name2'] . "</b> utilise son sort de potion acide.";
			if($value==1414)
				echo "<b>". $_GET['name2'] . "</b> essaye d'utiliser potion acide sans succès, plus assez de potion.";
			//Berserker
			if($value==15)
				echo "<b>". $_GET['name'] . "</b> utilise son sort de rage.";
			if($value==16)
				echo "<b>". $_GET['name'] . "</b> essaye d'utiliser rage sans succes, plus assez de PV.";
			if($value==1515)
				echo "<b>". $_GET['name2'] . "</b> utilise son sort de rage.";
			if($value==1616)
				echo "<b>". $_GET['name2'] . "</b> essaye d'utiliser rage sans succes, plus assez de PV.";
			//Moine
			if($value==17)
				echo "<b>". $_GET['name'] . "</b> utilise son sort de méditation.";
			if($value==1717)
				echo "<b>". $_GET['name2'] . "</b> utilise son sort de méditation.";
		}

	echo  "</fieldset></center>";
?>
	<footer><img src="images/bottom-bar.png"></footer>
</body>
</html>
