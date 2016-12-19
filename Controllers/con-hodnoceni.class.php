<?php
class ConHodnoceni{
	public function __construct(){
		
	}
	
	/***
	 * Spravuje zobrazování hodnocení
	 * @param unknown $prispevekID
	 * @param unknown $db
	 * @return string|unknown
	 */
	public function getResult($prispevekID, $db){
		include("View/view-hodnoceni.class.php");	
		$zprava = $db->vratHodnoceni($_SESSION["user"]["idkupilik_user"], $prispevekID);
		
		if(isset($_POST["uloz"])){
			echo($_POST["originalita"]);
			$db->upravHodnoceni($zprava["idkupilik_hodnoceni"], $_POST["originalita"], $_POST["prinos"], $_POST["jazyk"]);
			return ViewHodnoceni::getTemplateOK();
		}
		
		$prispevek = $db->vratPrispevek($prispevekID);
		return ViewHodnoceni::getTemplate($zprava, $prispevek);
	}
}