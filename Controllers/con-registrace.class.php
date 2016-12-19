<?php

class ConRegistrace{
	
	private $db;
	
	public function __construct(){
		
		
	}
	
	/***
	 * Spravuje požadavky na registrování nového uživatele
	 * @return string
	 */
	public function getResult(){
		include("Models/mo-databaze.class.php");
		$db = new ModDatabaze();
		
		$zprava = null;
		if (isset ( $_POST ["potvrzeni"] )) {
			if (strcmp ( $_POST ["heslo"], $_POST ["heslo2"] ) != 0) {
				$zprava = "Neshodují se zadaná hesla!";
			} else if ($db->najdiUzivatele ( $_POST ["login"] ) != null) {
				$zprava = "Zadaný login již existuje!";
			}else{
				$db->pridejUzivatele($_POST ["login"], $_POST ["heslo"], $_POST ["jmeno"], $_POST ["email"]);
				$db->prihlasUzivatele($_POST ["login"]);
			}
		}
		
		if($db->jeNekdoPrihlasen() == false){
			include("View/view-registrace.class.php");
			
			return ViewRegistrace::getTemplate($zprava);
		}else{
			include("View/view-registrace.class.php");
			return  ViewRegistrace::getTemplate();
		}
		
		

	}
	
}