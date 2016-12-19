<?php
class ViewUvod{
	
	public function __construct(){
		
	}
	
	/***
	 * Zobrazí úvodní stránku
	 * @return string
	 */
	public function getResult(){
		$res = "";
		$res .= "
		<div class='col-5'>
        	<h1>Úvodní stránka</h1>
        </div>";
		
		include("View/view-hlavicky.class.php");
		
		return ViewHlavicky::getHTMLHeader().$res.ViewHlavicky::getHTMLFooter();
	}
}