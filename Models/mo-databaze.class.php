<?php
class ModDatabaze {
	private $db;
	
	/***
	 * Připojí se pomocí PDO k databázi.
	 */
	public function __construct() {
		$this->db = new PDO ( "mysql:host=localhost;dbname=semestralkadb", "root", "" );
	}
	
	/***
	 * Provede vytvořený dotaz
	 * @param unknown $dotaz
	 * @return NULL|PDOStatement
	 */
	private function executeQuery($dotaz) {
		$res = $this->db->query ( $dotaz );
		if (! $res) {
			$error = $this->db->errorInfo ();
			echo $error [2];
			return null;
		} else {
			return $res;
		}
	}
	
	/***
	 * Najde uživatele podle loginu
	 * @param unknown $login
	 * @return NULL|mixed
	 */
	public function najdiUzivatele($login) {
		$query = "SELECT * FROM kupilik_user WHERE login = :log;";
		$vystup = $this->db->prepare($query);
		$params = array(':log' => $login);
		if(!$vystup->execute($params)){
			return null;
		}
		$res = $vystup->fetchAll();
		
		if($res != null){
			return $res[0];
		}else{
			return null;
		}
	}
	
	/***
	 * Najde uživatele podle jeho ID.
	 * @param unknown $userID
	 * @return NULL|mixed
	 */
	public function najdiUzivateleID($userID){
		$q = "SELECT * FROM `kupilik_user` WHERE `idkupilik_user` = :userID;";
		
		$vystup = $this->db->prepare($q);
		$params = array(':userID' => $userID);
		if(!$vystup->execute($params)){
			return null;
		}
		$res = $vystup->fetchAll();
		
		if($res != null){
			return $res[0];
		}else{
			return null;
		}
	}
	
	/***
	 * Odstraní uživatele
	 * @param unknown $userID
	 */
	public function odstranUzivatele($userID){
		$q = "DELETE FROM `kupilik_user` WHERE `kupilik_user`.`idkupilik_user` = :userID";
		$vystup = $this->db->prepare($q);
		$params = array(':userID' => $userID);
		$vystup->execute($params);
	}
	
	/***
	 * Vrátí všechny uživatele kromě administrátora
	 * @return NULL
	 */
	public function vratVsechnyUzivateleBezAdmina(){
		$q = "SELECT * FROM `kupilik_user` WHERE `kupilik_prava_idkupilik_prava` <> '1';";
		$res = $this->executeQuery ( $q);
		$res = $res->fetchAll();
		
		if($res != null && count($res)>0){
			return $res;
		} else {
			return null;
		}
	}
	
	/***
	 * Zmení práva uživatele
	 * @param unknown $userID
	 * @param unknown $prava
	 */
	public function zmenPravaUzivatele($userID, $prava){		
		$q = "UPDATE `kupilik_user` SET `kupilik_prava_idkupilik_prava` = :prava WHERE `kupilik_user`.`idkupilik_user` = :userID;";
		$vystup = $this->db->prepare($q);
		$params = array(':prava' => $prava, ':userID' => $userID);
		$vystup->execute($params);
		
	}
	
	/**
	 * Přidá nového uživatele
	 * @param unknown $login
	 * @param unknown $heslo
	 * @param unknown $jmeno
	 * @param unknown $email
	 */
	public function pridejUzivatele($login, $heslo, $jmeno, $email) {
		$q = "INSERT INTO `kupilik_user` (`idkupilik_user`, `name`, `login`, `heslo`, `email`, `kupilik_prava_idkupilik_prava`) VALUES (?,?,?,?,?,?);";
		$vystup = $this->db->prepare($q);
		$login = htmlspecialchars($login);
		$heslo = htmlspecialchars($heslo);
		$jmeno = htmlspecialchars($jmeno);
		$email = htmlspecialchars($email);
		$vystup->execute(array(NULL, $jmeno, $login, $heslo, $email, 2));
	}
	
	/***
	 * Vrátí všechny recenzenty
	 * @return NULL
	 */
	public function vratRecenzenty(){
		$q = "SELECT * FROM `kupilik_user` WHERE `kupilik_prava_idkupilik_prava` = '3';";
		$res = $this->executeQuery ( $q);
		$res = $res->fetchAll();
		
		if($res != null && count($res)>0){
			return $res;
		} else {
			return null;
		}
	}
	
	/***
	 * Přihlásí uživatele 
	 * @param unknown $login
	 * @return boolean
	 */
	public function prihlasUzivatele($login){
		
		$_SESSION["user"] = $this->najdiUzivatele($login);
		return true;
	}

	public function odhlasUzivatele(){
		session_unset($_SESSION["user"]);
	}
	
	public function zkontrolujHeslo($login, $heslo){
		$uzivatel = $this->najdiUzivatele($login);
		if($uzivatel == null){
			return false;
		}
		
		return strcmp($uzivatel["heslo"], $heslo);
		
	}
	
	/***
	 * Vloží nový příspěvek do databáze
	 * @param unknown $file
	 * @param unknown $nazev
	 * @param unknown $autor
	 * @param unknown $abstract
	 * @param unknown $idUser
	 */
	public function vlozPrispevek($file, $nazev, $autor, $abstract, $idUser) {
		$q = "INSERT INTO `kupilik_prispevky`(`idkupilik_prispevky`, `nazev`, `autor`, `publikovano`, `abstract`, `kupilik_user_idkupilik_user`, `nazevSouboru`)
				VALUES (?,?,?,?,?,?,?)";
		$vystup = $this->db->prepare($q);
		$file = htmlspecialchars($file);
		$nazev = htmlspecialchars($nazev);
		$abstract = htmlspecialchars($abstract);
		$vystup->execute(array(NULL, $nazev, $autor, 0, $abstract, $idUser, $file));
	}
	
	/**
	 * Vrátí všechny příspěvky, které vložil do databáze autor
	 * @param unknown $userID
	 * @return NULL
	 */
	public function vratPrispevkyAutora($userID){
		$q = "SELECT * FROM `kupilik_prispevky` WHERE `kupilik_user_idkupilik_user`=:userID;";
		$vystup = $this->db->prepare($q);
		$params = array(':userID' => $userID);
		
		if(!$vystup->execute($params)){
			return null;
		}
		$res = $vystup->fetchAll();
		
		if($res != null){
			return $res;
		}else{
			return null;
		}
	}
	
	public function vratVsechnyPrispevky(){
		$q = "SELECT * FROM `kupilik_prispevky`;";
		$res = $this->executeQuery($q);
		$res = $res->fetchAll();
		
		if($res != null && count($res)>0){
			return $res;
		} else {
			return null;
		}
	}
	
	/***
	 * Vrátí všechny příspěvky, které byly recenzentovi přiděleny k hodnocení
	 * @param unknown $idRecenzenta
	 * @return NULL|NULL[]|mixed[]
	 */
	public function vratPrispevkyKHodnoceni($idRecenzenta){
		$q = "SELECT * FROM `kupilik_hodnoceni` WHERE `kupilik_user_idkupilik_user` = :idRecenzenta;";
		$vystup = $this->db->prepare($q);
		$params = array(':idRecenzenta' => $idRecenzenta);
		
		if(!$vystup->execute($params)){
			return null;
		}
		$res = $vystup->fetchAll();

		$res1 = [];
		$k = 0;
		for($i = 0; $i < sizeof($res); $i++){
			$pom = $this->vratPrispevek($res[$i]["kupilik_prispevky_idkupilik_prispevky"]);
			if($pom["publikovano"] == 0){
				$res1[$k] = $pom;
				$k++;
			}
		}
		return $res1;
	}
	
	public function vratNepublikovanePrispevky(){
		$q = "SELECT * FROM `kupilik_prispevky` WHERE `publikovano` = '0';";
		$res = $this->executeQuery($q);
		$res = $res->fetchAll();
		
		if($res != null && count($res)>0){
			return $res;
		} else {
			return null;
		}
	}
	
	public function publikujPrispevek($prispevekID){
		$q = "UPDATE `kupilik_prispevky` SET `publikovano` = '1' WHERE `kupilik_prispevky`.`idkupilik_prispevky` = :prispevekID;";
		$vystup = $this->db->prepare($q);
		$params = array(':prispevekID' => $prispevekID);
		
		$vystup->execute($params);
		
	}
	
	public function odmitniPrispevek($prispevekID){
		$q = "UPDATE `kupilik_prispevky` SET `publikovano` = '2' WHERE `kupilik_prispevky`.`idkupilik_prispevky` = :prispevekID;";
		$vystup = $this->db->prepare($q);
		$params = array(':prispevekID' => $prispevekID);
		
		$vystup->execute($params);
		
	}
	
	public function vratPublikovanePrispevky(){
		$q = "SELECT * FROM `kupilik_prispevky` WHERE `publikovano`='1';";
		$res = $this->executeQuery($q);
		$res = $res->fetchAll();
		
		if($res != null && count($res)>0){
			return $res;
		} else {
			return null;
		}
	}
	
	/***
	 * Vrátí příspěvek podle jeho ID
	 * @param unknown $prispevekID
	 * @return NULL|mixed
	 */
	public function vratPrispevek($prispevekID){
		$q = "SELECT * FROM `kupilik_prispevky` WHERE `idkupilik_prispevky` = :prispevekID;";
		$vystup = $this->db->prepare($q);
		$params = array(':prispevekID' => $prispevekID);
		
		if(!$vystup->execute($params)){
			return null;
		}
		$res = $vystup->fetchAll();
		
		if($res != null){
			return $res[0];
		}else{
			return null;
		}
	}
	
	/***
	 * Upraví příspěvek
	 * @param unknown $idPrispevek
	 * @param unknown $nazev
	 * @param unknown $abstract
	 * @param unknown $file
	 */
	public function upravPrispevek($idPrispevek, $nazev, $abstract, $file){
		$nazev = htmlspecialchars($nazev);
		$file = htmlspecialchars($file);
		$abstract = htmlspecialchars($abstract);
		$q = "UPDATE `kupilik_prispevky` SET `nazev` = :nazev, `abstract` = :abstract, `nazevSouboru` = :file WHERE `kupilik_prispevky`.`idkupilik_prispevky` = :idPrispevek;";
		$vystup = $this->db->prepare($q);
		$params = array(':nazev' => $nazev, ':abstract' => $abstract, ':file' => $file, ':idPrispevek' => $idPrispevek);
		
		$vystup->execute($params);
	}
	
	public function smazHodnoceniPrispevku($prispevekID){
		$q = "DELETE FROM `kupilik_hodnoceni` WHERE `kupilik_prispevky_idkupilik_prispevky` = :prispevekID;";
		$vystup = $this->db->prepare($q);
		$params = array(':prispevekID' => $prispevekID);
		
		$vystup->execute($params);
	}
	
	public function smazPrispevek($idPrispevku){
		$this->smazHodnoceniPrispevku($idPrispevku);
		$q = "DELETE FROM `kupilik_prispevky` WHERE `idkupilik_prispevky` = :idPrispevku;";
		$vystup = $this->db->prepare($q);
		$params = array(':idPrispevku' => $idPrispevku);
		
		$vystup->execute($params);
	}
	
	/***
	 * Vrátí všechna hodnocení příspěvku
	 * @param unknown $prispevekID
	 * @return NULL
	 */
	public function vratHodnoceniPodlePrispevku($prispevekID){
		$q = "SELECT * FROM `kupilik_hodnoceni` WHERE `kupilik_prispevky_idkupilik_prispevky` = :prispevekID;";
		$vystup = $this->db->prepare($q);
		$params = array(':prispevekID' => $prispevekID);
		
		if(!$vystup->execute($params)){
			return null;
		}
		$res = $vystup->fetchAll();
		
		if($res != null){
			return $res;
		}else{
			return null;
		}
	}
	
	public function odstranHodnoceni($hodnoceniID){
		$q = "DELETE FROM `kupilik_hodnoceni` WHERE `kupilik_hodnoceni`.`idkupilik_hodnoceni` = :hodnoceniID;";
		$vystup = $this->db->prepare($q);
		$params = array(':hodnoceniID' => $hodnoceniID);
		
		$vystup->execute($params);
	}
	
	public function vytvorHodnoceni($userID, $prispevekID){
		$q = "INSERT INTO `kupilik_hodnoceni` (`idkupilik_hodnoceni`, `originalita`, `prinos`, `jazykova_uroven`, `kupilik_user_idkupilik_user`, `kupilik_prispevky_idkupilik_prispevky`) VALUES (NULL, '0', '0', '0', '$userID', '$prispevekID');";
		$res = $this->executeQuery($q);
	}
	
	public function vratHodnoceni($userID, $prispevekID){
		$q = "SELECT * FROM `kupilik_hodnoceni` WHERE `kupilik_user_idkupilik_user` = :userID AND `kupilik_prispevky_idkupilik_prispevky` = :prispevekID;";
		$vystup = $this->db->prepare($q);
		$params = array(':userID' => $userID, ':prispevekID' => $prispevekID);
		
		if(!$vystup->execute($params)){
			return null;
		}
		$res = $vystup->fetchAll();
		
		if($res != null){
			return $res[0];
		}else{
			return null;
		}
	}
	
	/***
	 * Vrátí průměr známek z hodnocení
	 * @param unknown $userID
	 * @param unknown $prispevekID
	 * @return number
	 */
	public function vratHodnoceniPrumer($userID, $prispevekID){
		$res = $this->vratHodnoceni($userID, $prispevekID);
		$vysledek = ($res["originalita"] + $res["prinos"] + $res["jazykova_uroven"])/3;
		return $vysledek;
	}
	
	public function upravHodnoceni($hodnoceniID, $originalita, $prinos, $jazyk){
		$q = "UPDATE `kupilik_hodnoceni` SET `originalita` = :originalita, `prinos` = :prinos, `jazykova_uroven` = :jazyk WHERE `kupilik_hodnoceni`.`idkupilik_hodnoceni` = :hodnoceniID;";
		$vystup = $this->db->prepare($q);
		$params = array(':originalita' => $originalita, ':prinos' => $prinos, ':jazyk' => $jazyk, ':hodnoceniID' => $hodnoceniID);
		
		$vystup->execute($params);
		
	}
	
	/***
	 * Testuje, zda je někdo přihlášen
	 * @return unknown
	 */
	public function jeNekdoPrihlasen(){
		return isset($_SESSION["user"]);
	}
}