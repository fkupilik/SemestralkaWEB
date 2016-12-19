<?php
class ConPrihlaseni{
	
	public function __construct(){
		
		
	}
	
	/***
	 * Spravuje přihlašování uživatelů do systému
	 * @return string
	 */
	public function getResult(){
		include("Models/mo-databaze.class.php");
		$db = new ModDatabaze();
		$zprava = "";
		if(isset($_SESSION["user"])){
			$db->odhlasUzivatele();
		}
		
		if (isset ( $_POST ["potvrzeni"] )) {
			if($db->najdiUzivatele($_POST ["login"]) == null){
				$zprava .= "Zadaný login není v databázi!";
			}else if($db->zkontrolujHeslo($_POST ["login"], $_POST ["heslo"]) != 0){
				$zprava .= "Špatně zadané heslo!";
			}else{
				$db->prihlasUzivatele($_POST ["login"]);
				include("View/view-prihlaseniOK.class.php");
				return  ViewPrihlaseniOK::getTemplate($_SESSION["user"]);
			}
		}
		
		include("View/view-prihlaseni.class.php");
		return  ViewPrihlaseni::getTemplate($zprava);
	}
	
}
