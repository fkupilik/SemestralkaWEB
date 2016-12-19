<?php
class ConVlozPrispevek{
	public function __construct(){
		
	}
	
	/***
	 * Spravuje požadavky na vložení nového příspěvku
	 * @return string
	 */
	public function getResult(){
		include("Models/mo-databaze.class.php");
		$db = new ModDatabaze();
		$zprava = "";
		$zprava2 = "";
		$slozka = "uploads/";
		include("View/view-vlozPrispevek.class.php");
		
		if(isset($_POST ["potvrzeni"] )){
			$jmenoSouboru = rand(1000,100000)."-".$_FILES["fileToUpload"]["name"];
			$tmpName = $_FILES["fileToUpload"]["tmp_name"];
			move_uploaded_file($tmpName, $slozka.$jmenoSouboru);
			$idUser = $_SESSION["user"]["idkupilik_user"];
			$db->vlozPrispevek($jmenoSouboru, $_POST ["nazev"], $_SESSION["user"]["login"], $_POST ["abstract"], $idUser);
			return ViewVlozPrispevek::getTemplateOK();
		}
		
		if($db->jeNekdoPrihlasen() == false){
			$zprava .= "Vkládat příspěvky mohou jen přihlášení uživatelé!";
		}else if($_SESSION["user"]["kupilik_prava_idkupilik_prava"] != 2){
			$zprava .= "Vkládat příspěvky může jen autor!";
		}else{
			$zprava = null;
		}
		
			
		return ViewVlozPrispevek::getTemplate($zprava, $zprava2);
	}
}