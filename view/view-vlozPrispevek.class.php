<?php
class ViewVlozPrispevek{
	public function __construct(){
		
	}
	
	/***
	 * Zobrazí formulář pro vložení nového příspěvku.
	 * @param unknown $zprava
	 * @param unknown $zprava2
	 * @return string
	 */
	public static function getTemplate($zprava, $zprava2){
		include ("View/view-hlavicky.class.php");
		$text = "";
		if($zprava == null){
			$text .= '<div class="col-9">
				<h1>Nový příspěvek</h1>
					<form action="index.php?web=novyPrispevek" method="POST" enctype="multipart/form-data">
		
				<table>
		<tr>
			<td>Název:</td>
			<td><input type="text" name="nazev" required></td>
		</tr>
		<tr>
			<td>Abstract:</td>
			<td><input type="text" name="abstract" required></td>
		</tr>
		<tr>
			<td>Vyber soubor:</td>
			<td> <input type="file" name="fileToUpload" accept=".pdf" required></td>
		</tr>
		
	</table>
				<div style="text-align:center"> <input type="submit" name="potvrzeni" value="Vlož" ></div>
	</form>
					</div>';
		}else{
			$text .= "<div class='col-9'>
					<h1>$zprava</h1>
					</div>";
		}
			return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();			
	}
	
	public static function getTemplateOK(){
		include ("View/view-hlavicky.class.php");
		$text = "<div class='col-9'>
					<h1>Příspěvek byl vložen do databáze</h1>
					</div>";
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
	}
}