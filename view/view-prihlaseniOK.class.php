<?php
class ViewPrihlaseniOK{
	public function __construct(){
		
	}
	
	/***
	 * Úspěšné přihlášení uživatele
	 * @param unknown $user Login přihlášeného uživatele
	 * @return string html k zobrazení
	 */
	public static function getTemplate($user){
		include("view/view-hlavicky.class.php");
		$text ="";
		$text .=		"<div class=col-9>
				<h1 align='center'>Přihlášený uživatel</h1>
				<h2 align='center'>$user[login]</h2>
		</div>";
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();

	}
}