<html>
	<head>
		
		
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css" id="css" />
		<title>PHP Battle</title>
	</head>
	<body>
		<p style="text-align:center"><a href="index.php"><img src="images/top-bar1.png"></a></p>
		<center>
			<form method="post" action="battle.php">
				<fieldset>
					<legend> Entrez un nom de personnage </legend>
						<label for="perso"> Nom de personnage: </label>  <input placeholder="Entrez un nom" type="text" name="personnage" autofocus/>
				</fieldset>
				<br>
				<fieldset>
					<legend> Choisissez une classe </legend>
						<select name="classe">
							<option selected>Guerrier</option>
							<option>Alchimiste</option>
							<option>Assassin</option>
							<option>Berserker</option>
							<option>Mage</option>
							<option>Moine</option>
							<option>Pretre</option>
							<option>Voleur</option>
						</select>
				</fieldset>
				<br>
				<fieldset>
					<legend> Jouer </legend>
						<input class="buttonsubmit" type="submit" value="Envoyer" name="submit"/> <input class="buttonreset" type="reset" value="Effacer"/> 
				</fieldset>
			</form>
		</center>
		<?php
				if (isset($_GET['error'])) {
					echo "<center>
						<fieldset>
						<legend>Information</legend>";
					$error = $_GET['error'];
					if($error==1)
						echo "<font color='red'>Il n'y a pas assez de joueurs pour commencer un combat.</font>";
					if($error==2)
						echo "<font color='red'>Vous n'avez pas entré de nom.</font>";
					if($error==3)
						echo "<font color='red'>Vous n'avez pas entré de classe.</font>";
					if($error==4)
						echo "<font color='green'>Vous avez remporté ce combat.</font>";
					echo "</fieldset><br>";
				}
		?>
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
			echo "<center>" .
				"<fieldset>" .
				"<legend>Liste des personnages</legend>" .
				"<table><tr><th>Nom</th><th>Niveau</th><th>Classe</th><th>Expérience</th><th>Tués</th></tr>";

			$reponse = $pdo->query('SELECT * FROM perso'); 
			$count = 0;
			while($donnees = $reponse->fetch())
			{
				$count++;
				echo "<tr><td>" . $donnees['name'] . "</td>" . "<td>" . $donnees['level'] . "</td>" . "<td>". $donnees['classe'] . "</td><td>" . $donnees['curExp'] . "/" . $donnees['maxExp'] . "<td>" . $donnees['nbKills'] . "</tr>";
			}

			if ($count==0) 
				echo "Il n'y a pas encore de joueurs.";

			echo "</table></fieldset></center>";

			$reponse->closeCursor();
		?>

		<?php
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
			
			$reponse = $pdo->query('SELECT * FROM perso ORDER BY nbKills DESC')->fetch(); 
			echo "<center>
				<br>
				<fieldset>
				<legend>Hall of Fame</legend>
				Prosternez-vous devant <b>" . $reponse['name'] . "</b> ! <br> Combattez valeureusement pour peut-être... le détrôner ?!
				</fieldset></center>";
				
		?>
		<footer><img src="images/bottom-bar.png"></footer>
	</body>
</html>
