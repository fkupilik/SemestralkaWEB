<?php
class ConPrispevky{
	
	public function __construct(){		
		
	}

	
	/***
	 * Spravuje zobrazování příspěvků
	 * @return string
	 */
	public function getResult(){
		include("Models/mo-databaze.class.php");
		$db = new ModDatabaze();
		include("View/view-prispevky.class.php");
		$slozka = "uploads/";

		if(isset($_POST["hodnoceni"])){	// autor stiskne na tlačítko zobraz hodnocení u příspěvku, který vložil do systému		
			include("View/view-hodnoceni.class.php");
			$zprava = $db->vratHodnoceniPodlePrispevku($_POST["prispevekId"]);
			return ViewHodnoceni::getVsechnyHodnoceni($zprava, $db->vratPrispevek($_POST["prispevekId"]), $db);
		}
		
		if(isset($_POST["uloz"])){ // recenzent upraví svoje hodnocení a uloží
			include("View/view-hodnoceni.class.php");
			$db->upravHodnoceni($_POST["hodnoceniID"], $_POST["originalita"], $_POST["prinos"], $_POST["jazyk"]);
			return ViewHodnoceni::getTemplateOK();
		}
		
		if(isset($_POST["hodnot"])){ // recenzent chce hodnotit příspěvek
			include("Controllers/con-hodnoceni.class.php");
			$hodnoceni = new ConHodnoceni();
			$zprava = $db->vratHodnoceni($_SESSION["user"]["idkupilik_user"], $_POST["prispevekID"]);
			$prispevek = $db->vratPrispevek($_POST["prispevekID"]);
			return ViewPrispevky::getTemplateHodnoceni($zprava, $prispevek);
		}
		
		if(isset($_POST["odstranHodnoceni"])){
			$db->odstranHodnoceni($_POST["hodnoceniID"]);
			return ViewPrispevky::getTemplateAdministrator($db);
		}
		
		if(isset($_POST["prirad"])){
			$db->vytvorHodnoceni($_POST["recenzenti"], $_POST["prispevekID"]);
			return ViewPrispevky::getTemplateAdministrator($db);
		}
		
		if(isset($_POST["prirad1"])){
			$db->vytvorHodnoceni($_POST["recenzenti1"], $_POST["prispevekID"]);
			return ViewPrispevky::getTemplateAdministrator($db);
		}
		
		if(isset($_POST["prijmiPrispevek"])){
			$db->publikujPrispevek($_POST["prispevekID"]);
			return ViewPrispevky::getTemplateAdministrator($db);
		}
		
		if(isset($_POST["odmitniPrispevek"])){
			$db->odmitniPrispevek($_POST["prispevekID"]);
			return ViewPrispevky::getTemplateAdministrator($db);
		}
		
		if(isset( $_POST ["upraveno"] )){
			$jmenoSouboru = rand(1000,100000)."-".$_FILES["fileToUpload"]["name"];
			$tmpName = $_FILES["fileToUpload"]["tmp_name"];
			move_uploaded_file($tmpName, $slozka.$jmenoSouboru);
			$idUser = $_SESSION["user"]["idkupilik_user"];
			$db->upravPrispevek($_POST["prispevekId"], $_POST["nazev"], $_POST["abstract"], $jmenoSouboru);
			$userID = $_SESSION["user"]["idkupilik_user"];
			$zprava = $db->vratPrispevkyAutora($userID);
			return ViewPrispevky::getTemplateAutor($zprava);
		}
		
		if(isset ( $_POST ["uprav"] )){
			$zprava = $db->vratPrispevek($_POST["userId"]);
			return ViewPrispevky::getTemplateUprav($zprava);
		}
		
		if(isset ( $_POST ["smaz"] )){
			$db->smazPrispevek($_POST["userId"]);
			$userID = $_SESSION["user"]["idkupilik_user"];
			$zprava = $db->vratPrispevkyAutora($userID);
			return ViewPrispevky::getTemplateAutor($zprava);
		}
		
		if(isset ( $_POST ["zobraz"] )){
			$zprava = $db->vratPrispevek($_POST["prispevekID"]);
			return ViewPrispevky::getTemplatePrispevek($zprava["nazev"], $zprava["autor"], $zprava["abstract"], $zprava["nazevSouboru"]);
		}
		if(isset($_SESSION["user"]) == false){ // nikdo není přihlášen
			$zprava = $db->vratPublikovanePrispevky();
			return ViewPrispevky::getTemplateNeprihlaseny($zprava);		
		}else if($_SESSION["user"]["kupilik_prava_idkupilik_prava"] == 2){ // je přihlášen autor
			$userID = $_SESSION["user"]["idkupilik_user"];
			$zprava = $db->vratPrispevkyAutora($userID);
			return ViewPrispevky::getTemplateAutor($zprava);
		}else if($_SESSION["user"]["kupilik_prava_idkupilik_prava"] == 1){ // je přihlášen administrátor
			
			return ViewPrispevky::getTemplateAdministrator($db);
		}else if($_SESSION["user"]["kupilik_prava_idkupilik_prava"] == 3){ // je přihlášen recenzent
			$zprava = $db->vratPrispevkyKHodnoceni($_SESSION["user"]["idkupilik_user"]);
			return ViewPrispevky::getTemplateRecenzent($zprava, $db);
		}
		
	}
}