<?php
	class Player
	{		
		/* Player informations */
		private $name;	 
		private $classe;    			
		private $level;		
		private $curLife;   				
		private $maxLife;
		private $curExp;
		private $maxExp;
		private $cooldown;

		/* Player battle stats */
		private $damage;
		private $nbKills;

		/* Player inventory */
		private $nbPots;
		
		/* Player skill */
		private $bloc = false;
	  
		/* Player constructor */ 
		public function __construct($name, $classe, $level, $curLife, $maxLife, $curExp, $maxExp, $damage, $nbKills, $nbPots, $cooldown) {
			$this->setName($name);
			$this->setClasse($classe);
			$this->setLevel($level);
			$this->setCurLife($curLife);
			$this->setMaxLife($maxLife);
			$this->setCurExp($curExp);
			$this->setMaxExp($maxExp);
			$this->setDamage($damage);
			$this->setNbKills($nbKills);
			$this->setNbPots($nbPots);
			$this->setCooldown($cooldown);
		}

		/* Battle functions */ 
		public function doDamage(Player $ennemy) {
			$degat = $this->getDamage();
			$lifeAfterHited = $ennemy->getCurLife() - $degat;
			if($lifeAfterHited<=0) 
			{
				$ennemy->delete();
				$this->winBattle();
			}
			else {
				$ennemy->setCurLife($lifeAfterHited);
			}
			return $degat;
		}
		public function takePotion() {
			if ($this->getNbPots() > 0 && $this->getCurLife() < $this->getMaxLife()) {
				$this->setNbPots($this->getNbPots()-1);
				$lifeLeft = $this->getCurLife() + 25;

				if($lifeLeft > $this->getMaxLife()) 
					$this->setCurLife($this->getMaxLife());
				else
					$this->setCurLife($lifeLeft);

				$this->save();
			}
		}
		public function soin(){
			$life = $this->getMaxLife();
			$soin = (1*(5/100*$life));
			$lifeLeft = $this->getCurLife() + $soin;

			if($lifeLeft > $this->getMaxLife()) 
				$this->setCurLife($this->getMaxLife());
			else
				$this->setCurLife($lifeLeft);

			$this->save();
			
			return $soin;
		}
		public function winBattle() {
			$this->setNbKills($this->getNbKills()+1);
			$this->setNbPots($this->getNbPots()+1);

			if($this->getCurExp()>=90) {
				$this->setCurExp(0);
				$this->setLevel($this->getLevel()+1);
				$this->setMaxLife((100+($this->getLevel()*5)));
				$this->setCurLife($this->getMaxLife());
			}
			else {
				$this->setCurExp($this->getCurExp()+10);
				echo $this->getCurExp();
			}
			$this->save();
		}
		public function vol($ennemy){
			$retour = 0;
			$alea = rand(1,3);
			if($alea == 1)
			{
				$ennemy->setNbPots($ennemy->getNbPots()-1);
				$this->setNbPots($this->getNbPots()+1);
				$ennemy->save();
				$this->save();
				$retour = 1;
			}
			return $retour;
		}
		public function poison($ennemy){
			$lifeAfterHited = $ennemy->getCurLife() - ($this->getDamage()*1.6);
			echo $lifeAfterHited;
			if($lifeAfterHited<=0) 
			{
				$ennemy->delete();
				$this->winBattle();
			}
			else {
				$ennemy->setCurLife($lifeAfterHited);
			}
			
		}
		public function potionAcid($ennemy){
			if($this->getNbPots() > 0)
			{
				$lifeAfterHited = $ennemy->getCurLife() - ($this->getDamage()*(rand(1, $this->getNbPots())));
				echo $lifeAfterHited;
				if($lifeAfterHited<=0) 
				{
					$ennemy->delete();
					$this->winBattle();
				}
				else {
					$ennemy->setCurLife($lifeAfterHited);
				}
			}
		}
		public function rage($ennemy){
			if($this->getCurLife() > 10)
			{
				$this->setCurLife($this->getCurLife() - 10);
				$this->save();
				$lifeAfterHited = $ennemy->getCurLife() - ($this->getDamage()*2.5);
				echo $lifeAfterHited;
				if($lifeAfterHited<=0) 
				{
					$ennemy->delete();
					$this->winBattle();
				}
				else {
					$ennemy->setCurLife($lifeAfterHited);
				}
			}
		}
		public function meditation()
		{
			$this->setMaxLife($this->getMaxLife() +($this->getMaxLife()/100)*2);
			$this->save();
		}
	  
		/*********************************************
		/* Player's informations getters and setters /
		/********************************************/

		public function setName($name) {
			$this->name=$name;
		}	
		public function getName() {
			return $this->name;
		}
		public function setClasse($classe) {
			$this->classe=$classe;
		}
		public function getClasse() {
			return $this->classe;
		}
		public function setLevel($level) {
			$this->level=$level;
		}
		public function getLevel() {
			return $this->level;
		}
		public function setCurLife($curLife) {
			$this->curLife=$curLife;
		}
		public function getCurLife() {
			return $this->curLife;
		}
		public function getMaxLife() {
			return $this->maxLife;
		}
		public function setMaxLife($maxLife) {
			$this->maxLife=$maxLife;
		}
		public function getCurExp() {
			return $this->curExp;
		}
		public function setCurExp($curExp) {
			$this->curExp=$curExp;
		}
		public function getMaxExp() {
			return $this->maxExp;
		}
		public function setMaxExp($maxExp) {
			$this->maxExp=$maxExp;
		}
		public function getDamage() {
			return $this->damage;
		}
		public function setDamage($damage) {
			$this->damage=$damage;
		}
		public function getNbKills() {
			return $this->nbKills;
		}
		public function setNbKills($nbKills) {
			$this->nbKills=$nbKills;
		}
		public function getNbPots() {
			return $this->nbPots;
		}
		public function setNbPots($nbPots) {
			$this->nbPots=$nbPots;
		}
		public function getCooldown() {
			return $this->cooldown;
		}

		public function setCooldown($cooldown) {
			$this->cooldown=$cooldown;
		}
		
		/********************************************
		/* Player update into the database          /
		/*******************************************/

		public function save() {
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
		
			$query = "UPDATE perso SET level=:level,curLife=:curLife,maxLife=:maxLife,curExp=:curExp,maxExp=:maxExp,damage=:damage,nbKills=:nbKills,nbPots=:nbPots,cooldown=:cooldown WHERE name=:name";
			$prep = null;
			try
			{
				$prep = $pdo->prepare($query);
				$prep->bindValue(":curExp", 30, PDO::PARAM_INT);
				$prep->bindValue(":name", $this->getName(), PDO::PARAM_STR);
				$prep->bindValue(":level", $this->getLevel(), PDO::PARAM_INT);
				$prep->bindValue(":curLife", $this->getCurLife(), PDO::PARAM_INT);
				$prep->bindValue(":maxLife", $this->getMaxLife(), PDO::PARAM_INT);
				$prep->bindValue(":curExp", $this->getCurExp(), PDO::PARAM_INT);
				$prep->bindValue(":maxExp", $this->getMaxExp(), PDO::PARAM_INT);
				$prep->bindValue(":damage", $this->getDamage(), PDO::PARAM_INT);
				$prep->bindValue(":nbKills", $this->getNbKills(), PDO::PARAM_INT);
				$prep->bindValue(":nbPots", $this->getNbPots(), PDO::PARAM_INT);
				$prep->bindValue(":cooldown", $this->getCooldown(), PDO::PARAM_INT);
				$prep->execute();
			}
			catch(PDOException $e)
			{	
				die("Impossible de mettre a jour un perso : ".$e->getMessage());
			}
			finally
			{
				if($prep != null)
					$prep->closeCursor();
			}
		}
		public function delete() {
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
		
			$query = "DELETE FROM perso WHERE name=:name";
       	 	$prep = null;
			try 
			{
       	     	$prep = $pdo->prepare($query);
            	$prep->bindValue(":name", $this->getName(), PDO::PARAM_STR);
            	$prep->execute();
       	 	} 
			catch (PDOException $e) 
			{
           		die("Impossible de supprimer une personne : " . $e->getMessage());
      	    } 
	        finally 
			{
       	    	if ($prep != null)
					$prep->closeCursor();
	        }
		}
		public function insert() {
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
			
			try
			{
				$query = "INSERT INTO perso(name,classe,level,curLife,maxLife,curExp,maxExp,damage,nbKills,nbPots,cooldown) VALUES (:name,:classe,:level,:curLife,:maxLife,:curExp,:maxExp,:damage,:nbKills,:nbPots,:cooldown)";
				$prep=null;
				$prep = $pdo->prepare($query);
				$prep->bindValue(":name", $this->getName(), PDO::PARAM_STR);
				$prep->bindValue(":classe", $this->getClasse(), PDO::PARAM_STR);
				$prep->bindValue(":level", $this->getLevel(), PDO::PARAM_INT);
				$prep->bindValue(":curLife", $this->getCurLife(), PDO::PARAM_INT);
				$prep->bindValue(":maxLife", $this->getMaxLife(), PDO::PARAM_INT);
				$prep->bindValue(":curExp", $this->getCurExp(), PDO::PARAM_INT);
				$prep->bindValue(":maxExp", $this->getMaxExp(), PDO::PARAM_INT);
				$prep->bindValue(":damage", $this->getDamage(), PDO::PARAM_INT);
				$prep->bindValue(":nbKills", $this->getNbKills(), PDO::PARAM_INT);
				$prep->bindValue(":nbPots", $this->getNbPots(), PDO::PARAM_INT);
				$prep->bindValue(":cooldown", $this->getCooldown(), PDO::PARAM_INT);
				$prep->execute();
			}
			catch(PDOException $e)
			{
				die("Impossible d'ajouter un perso : ".$e->getMessage);
			}
			finally
			{
				if($prep != null)
					$prep->closeCursor();
			}
		}
	}
?>