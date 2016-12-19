<?php
class ViewHodnoceni{
	
	public function __construct(){
		
	}
	
	/***
	 * Zobrazí autorovi, jak byl hodnocen jeho příspěvek
	 * @param unknown $zprava Všechna hodnocení
	 * @param unknown $prispevek Autorův příspěvek, u kterého chce uživatel zobrazit hodnocení
	 * @param unknown $db reference na databázi
	 * @return string html k zobrazení
	 */
	public static function getVsechnyHodnoceni($zprava, $prispevek, $db){
		include ("View/view-hlavicky.class.php");
		$text = '
				<div class="col-9">
				<h1 align="center">Hodnocení příspěvku '.$prispevek["nazev"].'</h3>
						
				<div class="tabulkaPrispevky">
				
				<table align="center">
					<tr>
						<th>Recenzent</th>
						<th>Originalita</th>
						<th>Přínos</th>
						<th>Jazyková úroveň</th>
						<th>Celkem</th>
					</tr>';

		foreach($zprava as $hodnoceni){
			$recenzent = $db->najdiUzivateleID($hodnoceni["kupilik_user_idkupilik_user"]);
			$prumer = ($hodnoceni["originalita"] + $hodnoceni["prinos"] + $hodnoceni["jazykova_uroven"])/3;
			$text .= '
					<tr>
						<td>'.$recenzent["name"].'</td>
						<td>'.$hodnoceni["originalita"].'</td>
						<td>'.$hodnoceni["prinos"].'</td>
						<td>'.$hodnoceni["jazykova_uroven"].'</td>
						<td>'.$prumer.'</td>
					</tr>
					';
		}
				$text .= '</table>
				</div>
				</div>
				';
		
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
	}
	
	/***
	 * Hodnocení je uloženo
	 * @return string html k zobrazení
	 */
	public static function getTemplateOK(){
		include ("View/view-hlavicky.class.php");
		$text = '<div class="col-9">
				<h3 align="center">Hodnocení uloženo</h3>
				</div>
				';
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
		
	}
	
}