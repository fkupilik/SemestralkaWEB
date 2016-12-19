<?php
class ConUzivatele{
	
	public function __construct(){
		
	}
	
	/***
	 * Spravuje zobrazení uživatelů administrátorovi
	 * @return string
	 */
	public function getResult(){
		include("Models/mo-databaze.class.php");
		$db = new ModDatabaze();
		include("View/view-uzivatele.class.php");
		
		if(isset($_POST["odstran"])){
			$db->odstranUzivatele($_POST["userId"]);		
			$zprava = $db->vratVsechnyUzivateleBezAdmina();
			return ViewUzivatele::getTemplate($zprava);
		}else if(isset($_POST["zpet"])){
			$zprava = $db->vratVsechnyUzivateleBezAdmina();
			return ViewUzivatele::getTemplate($zprava);
		}else if(isset($_POST["uloz"])){
			$prava = $_POST["prava"];
			$db->zmenPravaUzivatele($_POST["userId"], $prava);
			$zprava = $db->vratVsechnyUzivateleBezAdmina();
			return ViewUzivatele::getTemplate($zprava);
		}
		
		if( isset($_POST["zobraz"])){
			$uzivatel = $db->najdiUzivateleID($_POST["userId"]);
			$prispevkyNepub = $db->vratNepublikovanePrispevky();
			return ViewUzivatele::getTemplateUzivatel($uzivatel);
		}
		$zprava = $db->vratVsechnyUzivateleBezAdmina();
		return ViewUzivatele::getTemplate($zprava);
	}
}